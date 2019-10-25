<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @category      module
 * @package       oxps/${MODULE_NAME}
 * @author        OXID Professional services
 * @link          http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2017
 */

/**
 * Class oxpsPasswordPolicyUser
 */
class oxpsPasswordPolicyCheckoutUser extends oxpsPasswordPolicyCheckoutUser_parent
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
        $this->_oxpsPasswordPolicyUser_init_parent();

        $this->setPasswordPolicy();
    }

    /**
     * Parent `init` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyUser_init_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::init();
        // @codeCoverageIgnoreEnd
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
     * Overridden registration render method to add password policy parameters.
     *
     * @return string
     */
    public function render()
    {

        // Assign current settings values
        $this->_aViewData = array_merge($this->_aViewData, $this->getPasswordPolicy()->getModuleSettings());

        // Parent call
        return $this->_oxpsPasswordPolicyUser_render_parent();
    }

    /**
     * @return object Password policy module instance.
     */
    public function getPasswordPolicy()
    {
        return $this->_oPasswordPolicy;
    }

    /**
     * Parent `render` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyUser_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
