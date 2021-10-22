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
    private const SETTINGS_PREFIX = 'oxpspasswordpolicy';
    public const SETTING_GOOD_PASSWORD_LENGTH = self::SETTINGS_PREFIX . 'GoodPasswordLength';
    public const SETTING_MIN_PASSWORD_LENGTH = self::SETTINGS_PREFIX . 'MinPasswordLength';
    public const SETTING_DIGITS = self::SETTINGS_PREFIX . 'Digits';
    public const SETTING_SPECIAL = self::SETTINGS_PREFIX . 'Special';
    public const SETTING_API = self::SETTINGS_PREFIX . 'API';
    public const SETTING_ENZOIC_API_KEY = self::SETTINGS_PREFIX . 'EnzoicAPIKey';
    public const SETTING_ENZOIC_SECRET_KEY = self::SETTINGS_PREFIX . 'EnzoicSecretKey';
    public const SETTING_ENZOIC = self::SETTINGS_PREFIX . 'Enzoic';
    public const SETTING_HAVE_I_BEEN_PWNED = self::SETTINGS_PREFIX . 'HaveIBeenPwned';
    public const SETTING_UPPER = self::SETTINGS_PREFIX . 'UpperCase';
    public const SETTING_LOWER = self::SETTINGS_PREFIX . 'LowerCase';
    public const SETTING_DRIVER = self::SETTINGS_PREFIX . 'RateLimitingDrivers';
    public const SETTING_LIMIT = self::SETTINGS_PREFIX . 'RateLimitingLimit';
    public const SETTING_RATELIMITING = self::SETTINGS_PREFIX . 'RateLimiting';
    public const SETTING_MEMCACHED_HOST = self::SETTINGS_PREFIX . 'MemcachedHost';
    public const SETTING_MEMCACHED_PORT = self::SETTINGS_PREFIX . 'MemcachedPort';
    public const SETTING_TOTP = self::SETTINGS_PREFIX . 'TOTP';
    public const SETTING_ADMIN_USER = self::SETTINGS_PREFIX . 'admin';

    public function getMinPasswordLength(): int
    {
        return (int) Registry::getConfig()->getConfigParam(self::SETTING_MIN_PASSWORD_LENGTH, 8);
    }

    public function getGoodPasswordLength(): int
    {
        return (int) Registry::getConfig()->getConfigParam(self::SETTING_GOOD_PASSWORD_LENGTH, 12);
    }

    public function getPasswordNeedDigits(): bool
    {
        return $this->isConfigParam(self::SETTING_DIGITS);
    }

    public function getPasswordNeedUpperCase(): bool
    {
        return $this->isConfigParam(self::SETTING_UPPER);
    }

    public function getPasswordNeedLowerCase(): bool
    {
        return $this->isConfigParam(self::SETTING_LOWER);
    }

    public function getPasswordNeedSpecialCharacter(): bool
    {
        return $this->isConfigParam(self::SETTING_SPECIAL);
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
        return (string) Registry::getConfig()->getConfigParam(self::SETTING_ENZOIC_API_KEY);
    }

    public function getSecretKey(): string
    {
        return (string) Registry::getConfig()->getConfigParam(self::SETTING_ENZOIC_SECRET_KEY);
    }

    public function isAPI(): bool
    {
        return $this->isConfigParam(self::SETTING_API);
    }

    public function isEnzoic(): bool
    {
        return $this->isConfigParam(self::SETTING_ENZOIC);
    }

    public function isHaveIBeenPwned(): bool
    {
        return $this->isConfigParam(self::SETTING_HAVE_I_BEEN_PWNED);
    }

    public function isRateLimiting(): bool
    {
        return $this->isConfigParam(self::SETTING_RATELIMITING);
    }

    public function isTOTP(): bool
    {
        return $this->isConfigParam(self::SETTING_TOTP);
    }

    public function isAdminUsers(): bool
    {
        return $this->isConfigParam(self::SETTING_ADMIN_USER);
    }

    public function getSelectedDriver(): string
    {
        return (string) Registry::getConfig()->getConfigParam(self::SETTING_DRIVER);
    }

    public function getRateLimit(): int
    {
        return (int) Registry::getConfig()->getConfigParam(self::SETTING_LIMIT, 60);
    }

    public function getMemcachedHost(): string
    {
        return (string) Registry::getConfig()->getConfigParam(self::SETTING_MEMCACHED_HOST);
    }

    public function getMemcachedPort(): int
    {
        return (int) Registry::getConfig()->getConfigParam(self::SETTING_MEMCACHED_PORT, 11211);
    }
    private function isConfigParam(string $name): bool
    {
        return (bool) Registry::getConfig()->getConfigParam($name, true);
    }
}
