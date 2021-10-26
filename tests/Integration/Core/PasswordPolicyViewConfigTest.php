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

namespace OxidProfessionalServices\PasswordPolicy\Tests\Integration\Core;

use OxidEsales\Eshop\Core\InputValidator;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyViewConfig;
use PHPUnit\Framework\TestCase;

/**
 * Tests for "PasswordPolicyModule" class
 */
class PasswordPolicyViewConfigTest extends TestCase
{

    /**
     * @var PasswordPolicyViewConfig
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
        $this->subjectUnderTest = new PasswordPolicyViewConfig();
    }

    /**
     */
    public function testGetJsonPasswordPolicySettings(): void
    {
        $json = $this->subjectUnderTest->getJsonPasswordPolicySettings();
        $array = json_decode($json, true);
        $this->assertCount(6, $array);
        $this->assertArrayHasKey('minPasswordLength', $array);
        $this->assertArrayHasKey('goodPasswordLength', $array);
        $this->assertArrayHasKey('digits', $array);
        $this->assertArrayHasKey('special', $array);
        $this->assertArrayHasKey('lowercase', $array);
        $this->assertArrayHasKey('uppercase', $array);
        $this->assertInternalType('int', $array['minPasswordLength']);
        $this->assertInternalType('int', $array['goodPasswordLength']);
        $this->assertInternalType('bool', $array['digits']);
        $this->assertInternalType('bool', $array['special']);
        $this->assertInternalType('bool', $array['lowercase']);
        $this->assertInternalType('bool', $array['uppercase']);
    }
}
