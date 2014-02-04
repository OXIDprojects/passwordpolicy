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

class Admin_OxpsPasswordPolicy extends oxAdminView
{

    /**
     * Current class template name.
     * @var string
     */
    protected $_sThisTemplate = 'admin_oxpspasswordpolicy.tpl';

    /**
     * @var object $_oPasswordPolicy Password policy module instance.
     */
    protected $_oPasswordPolicy;


    function __construct()
    {

        // Parent call
        $this->_admin_OxpsPasswordPolicy_construct_parent();
    }


    /**
     * Overridden init method, that creates password policy module object.
     */
    public function init()
    {
        // Parent init call
        $this->_admin_OxpsPasswordPolicy_init_parent();

        $this->setPasswordPolicy();
    }


    /**
     * Set Password Policy instance
     *
     * @param mixed $mPasswordPolicy
     */
    public function setPasswordPolicy($oPasswordPolicy = null)
    {
        $this->_oPasswordPolicy = is_object($oPasswordPolicy) ? $oPasswordPolicy : oxNew('OxpsPasswordPolicyModule');
    }

    /**
     * @return object Password policy module instance.
     */
    public function getPasswordPolicy()
    {
        return $this->_oPasswordPolicy;
    }


    /**
     * Overridden render method for settings form display.
     *
     * @return string
     */
    public function render()
    {

        // Assign current settings values
        $this->_aViewData = array_merge($this->_aViewData, $this->getPasswordPolicy()->getModuleSettings());

        // Parent render call
        return $this->_admin_OxpsPasswordPolicy_render_parent();
    }


    /**
     * Settings form action callback for validating and saving the settings.
     *
     * @return string|void
     */
    public function save()
    {
        // Constants and initial params
        $oConfig = $this->getConfig();
        $sPrefix = 'passwordpolicy_';
        $oModule = $this->getPasswordPolicy();
        $aRequirementsOptions = $oModule->getPasswordRequirementsOptions();
        $aRequirements = array();

        // Get values from a request
        $iMaxAttemptsAllowed = $oConfig->getRequestParameter($sPrefix . 'maxattemptsallowed');
        $iTrackingPeriod = $oConfig->getRequestParameter($sPrefix . 'trackingperiod');
        $blAllowUnblock = (bool)$oConfig->getRequestParameter($sPrefix . 'allowunblock');
        $iMinPasswordLength = (int)$oConfig->getRequestParameter($sPrefix . 'minpasswordlength');
        $iGoodPasswordLength = (int)$oConfig->getRequestParameter($sPrefix . 'goodpasswordlength');
        $iMaxPasswordLength = (int)$oConfig->getRequestParameter($sPrefix . 'maxpasswordlength');
        $aPasswordRequirements = (array)$oConfig->getRequestParameter($sPrefix . 'requirements');

        // Validate values and save to settings
        if (!is_null($iMaxAttemptsAllowed) and $oModule->validatePositiveInteger((int)$iMaxAttemptsAllowed)) {
            $oModule->saveShopConfVar("int", "iMaxAttemptsAllowed", (int)$iMaxAttemptsAllowed);
        }

        if (!is_null($iTrackingPeriod) and $oModule->validatePositiveInteger((int)$iTrackingPeriod)) {
            $oModule->saveShopConfVar("int", "iTrackingPeriod", (int)$iTrackingPeriod);
        }

        $oModule->saveShopConfVar("bool", "blAllowUnblock", $blAllowUnblock);

        if (($iMinPasswordLength <= $iGoodPasswordLength) and ($iGoodPasswordLength <= $iMaxPasswordLength)) {

            if ($oModule->validatePositiveInteger($iMinPasswordLength, 6)) {
                $oModule->saveShopConfVar("int", "iMinPasswordLength", $iMinPasswordLength);
            }

            if ($oModule->validatePositiveInteger($iGoodPasswordLength)) {
                $oModule->saveShopConfVar("int", "iGoodPasswordLength", $iGoodPasswordLength);
            }

            if ($oModule->validatePositiveInteger($iMaxPasswordLength)) {
                $oModule->saveShopConfVar("int", "iMaxPasswordLength", $iMaxPasswordLength);
            }
        }

        if (is_array($aPasswordRequirements)) {

            // Check posted options and build array for saving
            foreach ($aRequirementsOptions as $option) {
                $aRequirements[$option] = !empty($aPasswordRequirements[$option]);
            }

            $oModule->saveShopConfVar("aarr", "aPasswordRequirements", $aRequirements);
        }

        $this->_aViewData["message"] = 'OXPS_PASSWORDPOLICY_ADMIN_SAVED';
    }


    /**
     * Parent `__construct` call. Method required for mocking.
     *
     * @return null
     */
    protected function _admin_OxpsPasswordPolicy_construct_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::__construct();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `init` call. Method required for mocking.
     *
     * @return null
     */
    protected function _admin_OxpsPasswordPolicy_init_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::init();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `render` call. Method required for mocking.
     *
     * @return null
     */
    protected function _admin_OxpsPasswordPolicy_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
