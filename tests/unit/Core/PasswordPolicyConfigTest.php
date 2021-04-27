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

namespace OxidProfessionalServices\PasswordPolicy\Tests;

use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use PHPUnit\Framework\TestCase;

/**
 * Tests for "PasswordPolicyModule" class
 */
class PasswordPolicyConfigTest extends TestCase
{

    /**
     * @var PasswordPolicyConfig
     */
    protected $subjectUnderTest;


    /**
     * Set initial objects state.
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        $this->subjectUnderTest = new PasswordPolicyConfig();
    }
    /**
     * @dataProvider lengthProvider
     * @param int $len
     */
    public function testGetGoodPasswordLength(int $len): void
    {
        $this->saveGoodPasswordLength($len);
        $this->assertEquals($len, $this->subjectUnderTest->getGoodPasswordLength());
    }

    public function lengthProvider()
    {
        return array_map(function ($i) {
            return [$i];
        }, [0,1,2,14,99,100,255]);
    }

    /**
     * @dataProvider trueFalseProvider
     * @param $trueOrFalse
     */
    public function getNeedSpecialDigits($trueOrFalse): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingDigits, $trueOrFalse);
        $this->assertEquals($trueOrFalse, $this->subjectUnderTest->getPasswordNeedDigits());
    }

    /**
     * @dataProvider trueFalseProvider
     * @param $trueOrFalse
     */
    public function getNeedSpecial($trueOrFalse): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingSpecial, $trueOrFalse);
        $this->assertEquals($trueOrFalse, $this->subjectUnderTest->getPasswordNeedSpecialCharacter());
    }

    /**
     * @dataProvider trueFalseProvider
     * @param $trueOrFalse
     */
    public function getNeedLower($trueOrFalse): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingLower, $trueOrFalse);
        $this->assertEquals($trueOrFalse, $this->subjectUnderTest->getPasswordNeedSpecialCharacter());
    }


    public function trueFalseProvider()
    {
        return [
            [true],
            [false]
        ];
    }

    public function saveGoodPasswordLength(int $len): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingGoodPasswordLength, $len);
    }

    public function savePasswordNeedDigits(bool $need): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingDigits, $need);
    }

    public function savePasswordNeedUpperCase(bool $need): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingUpper, $need);
    }

    public function savePasswordNeedLowerCase(bool $need): void
    {
        $this->setConfig(PasswordPolicyConfig::SettingLower, $need);
    }

    /**
     * Set config param for testing
     * @param string $name
     * @param mixed $value
     */
    public function setConfig($name, $value): void
    {
        Registry::getConfig()->setConfigParam($name, $value);
    }
}
