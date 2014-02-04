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
 * Extend user component to intercept login failures
 */

class OxpsPasswordPolicyUser extends OxpsPasswordPolicyUser_parent
{

    /**
     * @var object $_oPasswordPolicy Password policy module instance.
     */
    protected $_oPasswordPolicy;


    /**
     * Overridden init method, that creates password policy module object.
     */
    public function init()
    {

        // Parent init call
        $this->_oxpsPasswordPolicyUser_init_parent();

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
     * Overridden login method.
     * Calls login attempts handler if user was found.
     */
    public function login()
    {
        // Parent login call
        $mLoginResponse = $this->_oxpsPasswordPolicyUser_login_parent();

        $oUser = oxNew('oxUser');

        // Try loading user by username
        $iUserId = $oUser->getIdByUserName(oxRegistry::getConfig()->getRequestParameter('lgn_usr'));

        // Continue with login attempts logic only if user id valid and user is loaded
        if (!empty($iUserId) and $oUser->load($iUserId) and $oUser->getId()) {
            $this->_handleLoginAttempts($oUser);
        }

        return $mLoginResponse;
    }

    /**
     * Overridden user creation method to add password policy validation.
     *
     * @return mixed
     */
    public function createUser()
    {
        // Validate password using password policy rules
        $oModule = $this->getPasswordPolicy();
        $oConfig = oxRegistry::getConfig();

        if (is_object($oModule) and $oConfig->getRequestParameter('lgn_pwd') and
                                    $oModule->validatePassword($oConfig->getRequestParameter('lgn_pwd'))
        ) {
            return false;
        }

        // Parent create user call
        return $this->_oxpsPasswordPolicyUser_createUser_parent();
    }


    /**
     * Checks if user must be blocked on login failures;
     *  Tracks login attempts;
     *  Purges attempts logs on login success.
     *
     * @param object $oUser
     */
    protected function _handleLoginAttempts($oUser)
    {

        // User object must be valid and loaded
        if (($oUser instanceof oxUser) and $oUser->getId()) {

            // Check user status
            if (empty($oUser->oxuser__oxactive->value)) {

                // Redirect user to block page if he is not active.
                $this->_redirectBlockedUser();
                return;
            }

            // Create attempts object and assign user
            $oAttempt = oxNew('OxpsPasswordPolicyAttempt');
            $oAttempt->setUser($oUser);
            $oAttempt->setMaxAttemptsAllowed(
                (int)$this->getConfig()->getShopConfVar('iMaxAttemptsAllowed', null, 'oxpspasswordpolicy')
            );
            $oAttempt->setTrackingPeriod(
                (int)$this->getConfig()->getShopConfVar('iTrackingPeriod', null, 'oxpspasswordpolicy')
            );

            if ($this->getLoginStatus() == USER_LOGIN_FAIL) {

                // Log attempts
                $oAttempt->log();

                if ($oAttempt->maximumReached()) {

                    // Block user and redirect to blocked user page
                    $oUser->oxuser__oxactive = new oxField(0);
                    $oUser->save();

                    // Redirect user
                    $this->_redirectBlockedUser();
                    return;
                }
            } else {

                // Purge all login attempts for the user
                $oAttempt->clean();
            }

        }
    }

    /**
     * Redirect user to "account blocked" page.
     *
     * @return null
     */
    protected function _redirectBlockedUser()
    {
        // @codeCoverageIgnoreStart
        // Not covering redirects.

        oxRegistry::getUtils()->redirect(
            oxRegistry::getConfig()->getShopHomeURL() . 'cl=oxpspasswordpolicy',
            false,
            302
        );

        return null;
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `init` call. Method required for mocking.
     *
     * @return null
     */
    protected function _oxpsPasswordPolicyUser_init_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::init();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `login` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyUser_login_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::login();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `createUser` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyUser_createUser_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::createUser();
        // @codeCoverageIgnoreEnd
    }
}
