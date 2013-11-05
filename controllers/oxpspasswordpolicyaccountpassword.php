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
 * Password policy main controller
 */
class OxpsPasswordPolicyAccountPassword extends OxpsPasswordPolicyAccountPassword_parent
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
        $this->_oxpsPasswordPolicyAccountPassword_init_parent();

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
     * Overridden password changing form page render method to add password policy parameters.
     *
     * @return string
     */
    public function render()
    {

        // Assign current settings values
        $this->_aViewData = array_merge($this->_aViewData, $this->getPasswordPolicy()->getModuleSettings());

        // Parent call
        return $this->_oxpsPasswordPolicyAccountPassword_render_parent();
    }


    /**
     * Overridden password changing callback method to add password policy validation.
     *
     * @return mixed
     */
    public function changePassword()
    {
        $oModule = $this->getPasswordPolicy();

        // Validate password using password policy rules
        if (is_object($oModule) and $oModule->validatePassword(oxConfig::getParameter('password_new'))) {
            return false;
        }

        // Parent call
        return $this->_oxpsPasswordPolicyAccountPassword_changePassword_parent();
    }


    /**
     * Parent `init` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyAccountPassword_init_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::init();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `render` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyAccountPassword_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `changePassword` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyAccountPassword_changePassword_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::changePassword();
        // @codeCoverageIgnoreEnd
    }
}
