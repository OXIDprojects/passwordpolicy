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

/**
 * Tests for "OxpsPasswordPolicyAccountPassword" class
 */
class Unit_Module_Controllers_OxpsPasswordPolicyAccountPasswordTest extends OxidTestCase
{

    /**
     * @var OxpsPasswordPolicyAccountPassword
     */
    protected $SUT;


    /**
     * Set initial objects state.
     *
     * @return null|void
     */
    public function setUp()
    {
        parent::setUp();

        $this->SUT = $this->getMock('OxpsPasswordPolicyAccountPassword', array(
            'oxpsPasswordPolicyAccountPasswordInitParent',
            'oxpsPasswordPolicyAccountPasswordRenderParent',
            'oxpsPasswordPolicyAccountPasswordChangePasswordParent'
        ));
    }


    /**
     * `getPasswordPolicy` returns null if init have not run (nothing was set)
     */
    public function testGetPasswordPolicy_initNotRan_returnNull()
    {
        $this->assertNull($this->SUT->getPasswordPolicy());
    }

    /**
     * `getPasswordPolicy` returns `PasswordPolicyModule` object after init (or password policy set)
     */
    public function testGetPasswordPolicyInitRanReturnPasswordPolicyModuleInstance()
    {
        $this->SUT->init();

        $this->assertType('OxpsPasswordPolicyModule', $this->SUT->getPasswordPolicy());
    }


    /**
     * `render` should add Password Policy settings to ViewData array and call parent
     */
    public function testRenderAddPasswordPolicySettingsCallParent()
    {
        $this->SUT->expects($this->once())->method('oxpsPasswordPolicyAccountPasswordRenderParent');

        $aConfigKeys = array(
            'iMaxAttemptsAllowed', 'iTrackingPeriod', 'blAllowUnblock',
            'iMinPasswordLength', 'iGoodPasswordLength', 'iMaxPasswordLength', 'aPasswordRequirements'
        );

        $this->SUT->init();
        $this->SUT->render();
        $aViewData = $this->SUT->getViewData();

        foreach ($aConfigKeys as $sKey) {
            $this->assertArrayHasKey($sKey, $aViewData);
        }
    }


    /**
     * `changePassword` should only call parent if no Password Policy module instance set.
     */
    public function testChangePasswordNoModuleInstanceCallParent()
    {
        $this->SUT->expects($this->once())->method('oxpsPasswordPolicyAccountPasswordChangePasswordParent');

        $this->SUT->changePassword();
    }

    /**
     * `changePassword` should return false if password is invalid or empty
     */
    public function testChangePasswordInvalidPasswordReturnFalse()
    {
        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword'));
        $oModule->expects($this->once())->method('validatePassword')->will($this->returnValue('ERR'));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->never())->method('oxpsPasswordPolicyAccountPasswordChangePasswordParent');

        $this->SUT->init();
        $this->assertFalse($this->SUT->changePassword());
    }

    /**
     * `changePassword` should call parent if password is valid
     */
    public function testChangePasswordPasswordIsValidCallParent()
    {
        modConfig::getInstance()->setParameter('password_new', 'abcDEFG_123-pass');

        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword'));
        $oModule->expects($this->once())->method('validatePassword')
            ->with($this->equalTo('abcDEFG_123-pass'))->will($this->returnValue(''));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->once())->method('oxpsPasswordPolicyAccountPasswordChangePasswordParent');

        $this->SUT->init();
        $this->SUT->changePassword();
    }
}
