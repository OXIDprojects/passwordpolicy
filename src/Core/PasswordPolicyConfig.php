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

declare(strict_types=1);

namespace OxidProfessionalServices\PasswordPolicy\Core;

use OxidEsales\Eshop\Core\Registry;

/**
 * Password policy config helpers used in controllers mostly
 */
class PasswordPolicyConfig
{
    private const SettingsPrefix = 'oxpspasswordpolicy';
    public const SettingGoodPasswordLength = self::SettingsPrefix . 'GoodPasswordLength';
    public const SettingMinPasswordLength = self::SettingsPrefix . 'MinPasswordLength';
    public const SettingDigits = self::SettingsPrefix . 'Digits';
    public const SettingSpecial = self::SettingsPrefix . 'Special';
    public const SettingAPI = self::SettingsPrefix . 'API';
    public const SettingAPIKey = self::SettingsPrefix . 'APIKey';
    public const SettingSecretKey = self::SettingsPrefix . 'SecretKey';
    public const SettingUpper = self::SettingsPrefix . 'UpperCase';
    public const SettingLower = self::SettingsPrefix . 'LowerCase';

    public function getMinPasswordLength(): int
    {
        return (int) Registry::getConfig()->getConfigParam(self::SettingMinPasswordLength, 8);
    }

    public function getGoodPasswordLength(): int
    {
        return (int) Registry::getConfig()->getConfigParam(self::SettingGoodPasswordLength, 12);
    }

    public function getPasswordNeedDigits(): bool
    {
        return $this->isConfigParam(self::SettingDigits);
    }

    public function getPasswordNeedUpperCase(): bool
    {
        return $this->isConfigParam(self::SettingUpper);
    }

    public function getPasswordNeedLowerCase(): bool
    {
        return $this->isConfigParam(self::SettingLower);
    }

    public function getPasswordNeedSpecialCharacter(): bool
    {
        return $this->isConfigParam(self::SettingSpecial);
    }

    /**
     * returns the hardcoded maximum length for passwords
     * a maximum length is need to avoid problems when processing long data (e.g. bufferoverflows, memory limits)
     * 255 is used because most security checks will be happy finding the limit and
     * also it is big enough to allow secure passwords
     * @return int
     */
    public function getMaxPasswordLength(): int
    {
        //this hardcoded limit to simplify settings
        return 255;
    }

    public function getAPIKey(): string
    {
        return (string) Registry::getConfig()->getConfigParam(self::SettingAPIKey);
    }

    public function getSecretKey(): string
    {
        return (string) Registry::getConfig()->getConfigParam(self::SettingSecretKey);
    }

    public function getAPINeeded(): bool
    {
        return $this->isConfigParam(self::SettingAPI);
    }

    private function isConfigParam(string $name): bool
    {
        return (bool) Registry::getConfig()->getConfigParam($name, true);
    }
}
