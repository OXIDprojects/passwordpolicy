<?php
/**
 * This file is part of OXID Professional Services Password Policy module.
 *
 * OXID Professional Services Password Policy module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID Professional Services Password Policy module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID Professional Services Password Policy module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author        OXID Professional services
 * @link          http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2019
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
     * @return OxpsPasswordPolicyModule Password policy module instance.
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
