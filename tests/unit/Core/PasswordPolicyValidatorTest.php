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

use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyValidator;
use PHPUnit\Framework\TestCase;

/**
 * Tests for "PasswordPolicyModule" class
 */
class PasswordPolicyValidatorTest extends TestCase
{

    /**
     * @var PasswordPolicyValidator
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
        $this->subjectUnderTest = new PasswordPolicyValidator();
    }

    /**
     * @dataProvider lengthProvider
     * @param int $len
     */
    public function testGetPasswordLength(int $len): void
    {
        $this->savePasswordLength($len);
        $this->assertEquals($len, $this->subjectUnderTest->getPasswordLength());
    }

    public function lengthProvider(): array
    {
        return array_map(function ($i) {
            return [$i];
        }, [0,1,2,14,99,100,255]);
    }

    public function savePasswordLength(int $len): void
    {
        Registry::getConfig()->setConfigParam(PasswordPolicyConfig::SettingMinPasswordLength, (string) $len);
    }

    /**
     * returns
     */
    public function passwordPolicyProvider(): array
    {
        return array_merge(
            $this->withPolicyCombinations(
                "ThisPasswordFulfills5Requirements!",
                true
            ),
            $this->withPolicyCombinations(
                "NOLOWER1/",
                false,
                PasswordPolicyConfig::SettingLower,
            ),
            $this->withPolicyCombinations(
                "noupper1/",
                false,
                PasswordPolicyConfig::SettingUpper,
            ),
            $this->withPolicyCombinations(
                "noSpecial2Day",
                false,
                PasswordPolicyConfig::SettingSpecial
            ),
            $this->withPolicyCombinations(
                "2Short!",
                false
            )
        );
    }

    private function withPolicyCombinations(
        string $psw,
        bool $willPass,
        string $mainPolicyName='',
        bool $mainPolicyValue=true
    ): array {
        $permutations = $this->policyCombinations($mainPolicyName, $mainPolicyValue);
        $res = [];
        foreach ($permutations as $permutation) {
            $permutation[PasswordPolicyConfig::SettingMinPasswordLength] = 8;
            $res[] = [$permutation, $psw, $willPass];
        }

        return $res;
    }

    /**
     * return a array of policies that all have the $mainPolicyName set to the $mainPolicyValue
     * and the possible combination of other rules
     * @param $mainPolicyName
     * @param $mainPolicyValue
     */
    private function policyCombinations($mainPolicyName, $mainPolicyValue): array
    {
        $flags = [
            PasswordPolicyConfig::SettingLower => 1,
            PasswordPolicyConfig::SettingDigits => 2,
            PasswordPolicyConfig::SettingSpecial => 4,
            PasswordPolicyConfig::SettingUpper => 8,
        ];

        $res = [];
        foreach (range(0, 15) as $combination) {
            $permutation = [];
            foreach ($flags as $name => $flag) {
                $permutation[$name] = false;
                if (($combination & $flag) === $flag) {
                    $permutation[$name] = true;
                }
            }
            if ($mainPolicyName === '' || $permutation[$mainPolicyName] === $mainPolicyValue) {
                $res[]=$permutation;
            }
        }

        return $res;
    }


    /**
     * @dataProvider passwordPolicyProvider
     */
    public function testValidatePasswordPolicy(array $policy, string $password, bool $shouldPass)
    {
        $this->setPolicy($policy);
        $this->subjectUnderTest->validatePassword($password);
        $ex = $this->subjectUnderTest->getFirstValidationError();
        if ($shouldPass) {
            $this->assertNull($ex);
        } else {
            $this->assertInstanceOf(StandardException::class, $ex);
        }
    }


    private function setPolicy(array $policy)
    {
        foreach ($policy as $name => $value) {
            Registry::getConfig()->setConfigParam($name, $value);
        }
    }
}
