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
 * @link          https://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2021
 */

namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyModule;
use OxidEsales\Eshop\Application\Controller\Admin\AdminController;

class OxpsPasswordPolicyAdmin extends AdminController
{

    /**
     * Current class template name.
     * @var string
     *
     */
    //phpcs:ignore
    protected $_sThisTemplate = 'admin_oxpspasswordpolicy.tpl';

    /**
     * @var object $passwordPolicy Password policy module instance.
     */
    protected $passwordPolicy;


    public function __construct()
    {

        // Parent call
        $this->adminOxpsPasswordPolicyConstructParent();
    }


    /**
     * Overridden init method, that creates password policy module object.
     */
    public function init()
    {
        // Parent init call
        $this->adminOxpsPasswordPolicyInitParent();

        $this->setPasswordPolicy();
    }


    /**
     * Set Password Policy instance
     *
     * @param mixed $mPasswordPolicy
     */
    public function setPasswordPolicy($oPasswordPolicy = null)
    {
        $this->passwordPolicy = is_object($oPasswordPolicy) ? $oPasswordPolicy : oxNew(PasswordPolicyModule::class);
    }

    /**
     * @return PasswordPolicyModule Password policy module instance.
     */
    public function getPasswordPolicy()
    {
        return $this->passwordPolicy;
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
        return $this->adminOxpsPasswordPolicyRenderParent();
    }


    /**
     * Settings form action callback for validating and saving the settings.
     *
     * @return string|void
     */
    public function save()
    {
        // Constants and initial params
        $config = Registry::getConfig();
        $prefix = 'passwordpolicy_';
        $module = $this->getPasswordPolicy();
        $requirementsOptions = $module->getPasswordRequirementsOptions();
        $requirements = array();

        // Get values from a request
        $maxAttemptsAllowed = $config->getRequestParameter($prefix . 'maxattemptsallowed');
        $trackingPeriod = $config->getRequestParameter($prefix . 'trackingperiod');
        $allowUnblock = (bool)$config->getRequestParameter($prefix . 'allowunblock');
        $minPasswordLength = (int)$config->getRequestParameter($prefix . 'minpasswordlength');
        $goodPasswordLength = (int)$config->getRequestParameter($prefix . 'goodpasswordlength');
        $maxPasswordLength = (int)$config->getRequestParameter($prefix . 'maxpasswordlength');
        $passwordRequirements = (array)$config->getRequestParameter($prefix . 'requirements');

        // Validate values and save to settings
        if (!is_null($maxAttemptsAllowed) and $module->validatePositiveInteger((int)$maxAttemptsAllowed)) {
            $module->saveShopConfVar("int", "iMaxAttemptsAllowed", (int)$maxAttemptsAllowed);
        }

        if (!is_null($trackingPeriod) and $module->validatePositiveInteger((int)$trackingPeriod)) {
            $module->saveShopConfVar("int", "iTrackingPeriod", (int)$trackingPeriod);
        }

        $module->saveShopConfVar("bool", "blAllowUnblock", $allowUnblock);

        if (($minPasswordLength <= $goodPasswordLength) and ($goodPasswordLength <= $maxPasswordLength)) {
            if ($module->validatePositiveInteger($minPasswordLength, 6)) {
                $module->saveShopConfVar("int", "iMinPasswordLength", $minPasswordLength);
            }

            if ($module->validatePositiveInteger($goodPasswordLength)) {
                $module->saveShopConfVar("int", "iGoodPasswordLength", $goodPasswordLength);
            }

            if ($module->validatePositiveInteger($maxPasswordLength)) {
                $module->saveShopConfVar("int", "iMaxPasswordLength", $maxPasswordLength);
            }
        }

        if (is_array($passwordRequirements)) {
            // Check posted options and build array for saving
            foreach ($requirementsOptions as $option) {
                $requirements[$option] = !empty($passwordRequirements[$option]);
            }

            $module->saveShopConfVar("aarr", "aPasswordRequirements", $requirements);
        }

        $this->_aViewData["message"] = 'OXPS_PASSWORDPOLICY_ADMIN_SAVED';
    }


    /**
     * Parent `__construct` call. Method required for mocking.
     *
     * @return null
     */
    protected function adminOxpsPasswordPolicyConstructParent()
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
    protected function adminOxpsPasswordPolicyInitParent()
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
    protected function adminOxpsPasswordPolicyRenderParent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
