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
 * Overridden password reset controller.
 */
class OxpsPasswordPolicyForgotPwd extends OxpsPasswordPolicyForgotPwd_parent
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

        // Parent call
        $this->_oxpsPasswordPolicyForgotPwd_init_parent();

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
     * Overridden render method to add password policy parameters.
     *
     * @return string
     */
    public function render()
    {
        // Assign current settings values
        $this->_aViewData = array_merge($this->_aViewData, $this->getPasswordPolicy()->getModuleSettings());

        // Parent call
        return $this->_oxpsPasswordPolicyForgotPwd_render_parent();
    }


    /**
     * Overridden method.
     * Additionally checks if user is blocked and if unblock is allowed.
     * If so, then temporary unlocks the user to send an email.
     *
     * NOTE: This hack is implemented because otherwise it would require to do similar work-around with core mailer.
     */
    public function forgotPassword()
    {
        $oModule = $this->getPasswordPolicy();
        $mBlockUser = false;

        // Check if unlock is allowed by settings
        if (is_object($oModule) and $oModule->getModuleSetting('blAllowUnblock')) {

            $oUser = oxNew('oxUser');

            // Try loading user by username
            $iUserId = $oUser->getIdByUserName(oxConfig::getParameter('lgn_usr'));

            // Continue with temporary unblock if user exists and is blocked
            if (!empty($iUserId) and $oUser->load($iUserId) and empty($oUser->oxuser__oxactive->value)) {

                // Unblock the user and mark the user ass required to be blocked after parent call.
                $oUser->oxuser__oxactive = new oxField(true);
                $oUser->save();
                $mBlockUser = $iUserId;
            }
        }

        // Parent call
        $mResponse = $this->_oxpsPasswordPolicyForgotPwd_forgotPassword_parent();

        // Reload and block user again if set.
        $oUser = oxNew('oxUser');

        if (!empty($mBlockUser) and $oUser->load($mBlockUser)) {

            $oUser->oxuser__oxactive = new oxField(false);
            $oUser->save();
        }

        return $mResponse;
    }


    /**
     * Overridden method.
     * Executes Password Policy validation layer.
     * Load user to update before parent call and,
     * if unblock is allowed, unblocks the user on successful password update.
     *
     * @return mixed
     */
    public function updatePassword()
    {
        $oModule = $this->getPasswordPolicy();
        $mUnblockUser = false;

        // Validate password using password policy rules
        if (is_object($oModule) and $oModule->validatePassword(oxConfig::getParameter('password_new', true))) {
            return false;
        }

        // Check if unblock is allowed.
        $blAllowUnblock = (is_object($oModule) and $oModule->getModuleSetting('blAllowUnblock'));

        if ($blAllowUnblock) {

            // Save target user OXID.
            $oUser = oxNew('oxUser');

            // Load user by
            if ($oUser->loadUserByUpdateId(oxConfig::getParameter('uid'))) {
                $mUnblockUser = $oUser->getId();
            }
        }

        // Parent call
        $mParentReturn = $this->_oxpsPasswordPolicyForgotPwd_updatePassword_parent();

        // Check if unlock is allowed by settings, user is valid and update was successful
        if ($blAllowUnblock and $mUnblockUser and ($mParentReturn == 'forgotpwd?success=1')) {

            $oUser = oxNew('oxUser');

            // Load user by
            if ($oUser->load($mUnblockUser)) {
                $oUser->oxuser__oxactive = new oxField(true);
                $oUser->save();
            }
        }

        return $mParentReturn;
    }


    /**
     * Parent `init` call. Method required for mocking.
     *
     * @return null
     */
    protected function _oxpsPasswordPolicyForgotPwd_init_parent()
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
    protected function _oxpsPasswordPolicyForgotPwd_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `forgotPassword` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyForgotPwd_forgotPassword_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::forgotPassword();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `updatePassword` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyForgotPwd_updatePassword_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::updatePassword();
        // @codeCoverageIgnoreEnd
    }
}
