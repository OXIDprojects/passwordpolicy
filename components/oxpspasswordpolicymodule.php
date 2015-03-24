<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @category  module
 * @package   passwordpolicy
 * @author    OXID Professional services
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2012
 */

/**
 * Password policy common helpers used in controllers mostly
 *
 * @todo Make a code review according to Coding Guide standards.
 * @todo Create JS widget instead of currently used method.
 * @todo Use pass requirements from settings for strength indicator.
 * @todo-nice2have Create container, or interface, or trait, or something for PasswordPolicyModule.
 * @todo-nice2have Track last password change for each user and force changing after some period of time.
 * @todo-nice2have Integrate password validation deeper into user component.
 * @todo-nice2have (?) Think of checking if user really logged in before 
redirecting to blocked page
 */
class OxpsPasswordPolicyModule extends oxView
{

    /**
     * @var string Module ID used as module identifier in `oxconfig` DB table.
     */
    protected $_sModuleId = 'oxpspasswordpolicy';


    /**
     * Get module ID.
     *
     * @return string
     */
    public function getModuleId()
    {
        return $this->_sModuleId;
    }

    /**
     * Load module configuration value from database.
     *
     * @param string $sName Configuration value name.
     * @return mixed
     */
    public function getShopConfVar($sName)
    {
        // @codeCoverageIgnoreStart
        // Not covering eShop default functions

        return $this->getConfig()->getShopConfVar($sName, null, $this->getModuleId());
        // @codeCoverageIgnoreEnd
    }

    /**
     * Saves config value to database.
     *
     * @param string $sType
     * @param string $sName
     * @param mixed $mValue
     * @return null
     */
    public function saveShopConfVar($sType, $sName, $mValue)
    {
        // @codeCoverageIgnoreStart
        // Not covering eShop default functions

        return $this->getConfig()->saveShopConfVar($sType, $sName, $mValue, null, $this->getModuleId());
        // @codeCoverageIgnoreEnd
    }

    /**
     * Return module settings.
     *
     * @param bool $blReturnNames Returns only settings names array if TRUE.
     * @return array Loaded settings as assoc. array.
     */
    public function getModuleSettings($blReturnNames = false)
    {
        $aSettings = array(
            'iMaxAttemptsAllowed' => 'integer',
            'iTrackingPeriod' => 'integer',
            'blAllowUnblock' => 'boolean',
            'iMinPasswordLength' => 'integer',
            'iGoodPasswordLength' => 'integer',
            'iMaxPasswordLength' => 'integer',
            'aPasswordRequirements' => 'array',
        );

        if ($blReturnNames) {
            return array_keys($aSettings);
        }

        foreach ($aSettings as $sName => $sType) {
            $aSettings[$sName] = $this->getShopConfVar($sName);
            settype($aSettings[$sName], $sType);
        }

        return $aSettings;
    }

    /**
     * Get module setting value.
     *
     * @param string $sName One of available module settings.
     * @return mixed|null
     */
    public function getModuleSetting($sName)
    {
        if (empty($sName) or !is_string($sName)) {
            return null;
        }

        $aSettings = $this->getModuleSettings();

        return (isset($aSettings[$sName]) ? $aSettings[$sName] : null);
    }

    /**
     * Validate password with password policy rules.
     *
     * @param string $sPassword
     * @return string
     */
    public function validatePassword($sPassword)
    {
        if (is_array($sPassword) or is_object($sPassword) or is_resource($sPassword) or is_callable($sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_WRONGTYPE';
        }

        $sPassword = (string)$sPassword;
        $sError = '';
        $iPasswordLength = mb_strlen($sPassword, $this->getEncoding());

        // Load module settings
        $aSettings = $this->getModuleSettings();

        // Validate password according to settings params
        if ($iPasswordLength < $aSettings['iMinPasswordLength']) {
            $sError = 'ERROR_MESSAGE_PASSWORD_TOO_SHORT';
        }

        if ($iPasswordLength > $aSettings['iMaxPasswordLength']) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG';
        }

        if (!empty($aSettings['aPasswordRequirements']['digits']) and !preg_match('(\d+)', $sPassword)) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS';
        }

        if (!empty($aSettings['aPasswordRequirements']['capital']) and !preg_match('(\p{Lu}+)', $sPassword)) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESCAPITAL';
        }

        if (!empty($aSettings['aPasswordRequirements']['special']) and
            !preg_match('([\.,_@\~\(\)\!\#\$%\^\&\*\+=\-\\\/|:;`]+)', $sPassword)
        ) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL';
        }

        if (!empty($sError)) {
            oxRegistry::get("oxUtilsView")->addErrorToDisplay($sError);
        }

        return $sError;
    }

    /**
     * Get current encoding defined by configuration.
     *
     * @return string
     */
    public function getEncoding()
    {
        return (!empty($this->getConfig()->iUtfMode) ? 'UTF-8' : 'ISO-8859-15');
    }

    /**
     * Check if number is a positive integer.
     *
     * @param mixed $mNumber
     * @param mixed $mMin
     * @param mixed $mMax
     * @return bool
     */
    public function validatePositiveInteger($mNumber, $mMin = null, $mMax = null)
    {
        $bValid = (is_integer($mNumber) and ($mNumber > 0));

        if (!is_null($mMin)) {
            $bValid = ($bValid and ($mNumber >= $mMin));
        }

        if (!is_null($mMax)) {
            $bValid = ($bValid and ($mNumber <= $mMax));
        }

        return $bValid;
    }

    /**
     * Available password content requirements options.
     *
     * @return array
     */
    public function getPasswordRequirementsOptions()
    {
        return array('digits', 'capital', 'special');
    }

    /**
     * On module activation callback
     * Calls install.sql script
     */
    public static function onActivate()
    {
        // @codeCoverageIgnoreStart
        // Generated from developer tools, no need to test this
        self::_dbEvent( 'install.sql.tpl', 'Error activating module: ' );
        // @codeCoverageIgnoreEnd
    }

    /**
     * On module deactivation callback
     */
    public static function onDeactivate()
    {
        // @codeCoverageIgnoreStart
        // Generated from developer tools, no need to test this
        if ( function_exists( 'module_enabled_count' ) && module_enabled_count( 'oxpswatchlist' ) < 2 ) {
            self::_dbEvent( 'uninstall.sql', 'Error deactivating module: ' );
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Executes SQL queries form a file.
     *
     * @param string $sSqlFile      SQL file located in module docs folder (usually install.sql or uninstall.sql).
     * @param string $sFailureError An error message to show on failure.
     */
    protected static function _dbEvent( $sSqlFile, $sFailureError = "Operation failed: " )
    {
        // @codeCoverageIgnoreStart
        // Generated from developer tools, no need to test this
        try {
            $sSqlDir = dirname( __DIR__ ) . DIRECTORY_SEPARATOR . 'docs' . DIRECTORY_SEPARATOR . $sSqlFile;
            if ( preg_match( '/\.tpl$/', $sSqlFile ) ) { // If file extension is .tpl
                /** @var Smarty $oSmarty */
                $oSmarty = oxRegistry::get( 'oxUtilsView' )->getSmarty();
                $oSmarty->assign( 'oConfig', oxRegistry::getConfig() );
                $sSql = $oSmarty->fetch( $sSqlDir );
            } else {
                $sSql = file_get_contents( $sSqlDir );
            }

            $oDb  = oxDb::getDb();
            $aSql = explode( ';', $sSql );

            if ( !empty( $aSql ) ) {
                foreach ( $aSql as $sQuery ) {
                    if ( !empty( $sQuery ) ) {
                        $oDb->execute( $sQuery );
                    }
                }
            }

            self::cleanTmp();
        } catch ( Exception $ex ) {
            error_log( $sFailureError . $ex->getMessage() );
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * Delete cache files.
     *
     * @return bool
     */
    public static function cleanTmp()
    {
        // @codeCoverageIgnoreStart
        // Generated from developer tools, no need to test this
        if ( class_exists( 'D' ) ) {
            try {
                D::c();
            } catch ( Exception $ex ) {
                error_log( 'Cache files deletion failed: ' . $ex->getMessage() );
            }

            return true;
        } else {
            return false;
        }
        // @codeCoverageIgnoreEnd
    }
}
