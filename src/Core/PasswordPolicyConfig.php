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

namespace OxidProfessionalServices\PasswordPolicy\Core;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * Password policy config helpers used in controllers mostly
 */
class PasswordPolicyConfig extends PasswordPolicyConfig_parent
{

    /**
     * @var string Module ID used as module identifier in `oxconfig` DB table.
     */
    protected $moduleId = 'oxpspasswordpolicy';


    /**
     * Get module ID.
     *
     * @return string
     */
    private function getModuleId(): string
    {
        return $this->moduleId;
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

        return Registry::getConfig()->getConfigParam($sName);
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

        Registry::getConfig()->saveShopConfVar($sType, $sName, $mValue, null, 'module:' . $this->getModuleId());
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
            if ($sType == 'array' && $aSettings[$sName] === null) {
                $aSettings[$sName] = array();
            }
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
    public function getModuleSetting(string $sName)
    {
        $aSettings = $this->getModuleSettings();
        return (isset($aSettings[$sName]) ? $aSettings[$sName] : null);
    }


    /**
     * Check if number is a positive integer.
     *
     * @param mixed $mNumber
     * @param mixed $mMin
     * @param mixed $mMax
     * @return bool
     */
    public function validatePositiveInteger($mNumber): bool
    {
        return (is_integer($mNumber) and ($mNumber > 0));
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

    public function getJsonPasswordPolicySettings()
    {
        // Assign current settings values
        $settings = $this->getModuleSettings();
        $settings = array_merge($settings, $settings['aPasswordRequirements']);
        unset($settings['aPasswordRequirements']);
        return json_encode($settings, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    }

}
