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
class OxpsPasswordPolicy extends oxUBase
{

    /**
     * @var string Template name.
     */
    protected $_sThisTemplate = "passwordpolicyaccountblocked.tpl";


    /**
     * Overridden render method.
     * Adds shop URL to view data.
     *
     * @return mixed
     */
    public function render()
    {
        $oModule = oxNew('OxpsPasswordPolicyModule');

        $this->_aViewData['sShopUrl'] = oxRegistry::getConfig()->getShopUrl();
        $this->_aViewData['blAllowUnblock'] = (bool)$oModule->getModuleSetting('blAllowUnblock');

        // Parent render call
        return $this->_oxpsPasswordPolicy_render_parent();
    }


    /**
     * Parent `render` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicy_render_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
