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
 * Tests for "OxpsPasswordPolicyForgotPwd" class.
 */
class Unit_Module_Controllers_OxpsPasswordPolicyForgotPwdTest extends OxidTestCase
{

    /**
     * @var OxpsPasswordPolicyForgotPwd
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

        $this->SUT = $this->getMock(
            'OxpsPasswordPolicyForgotPwd',
            array(
                '_oxpsPasswordPolicyForgotPwd_init_parent',
                '_oxpsPasswordPolicyForgotPwd_render_parent',
                '_oxpsPasswordPolicyForgotPwd_forgotPassword_parent',
                '_oxpsPasswordPolicyForgotPwd_updatePassword_parent',
            )
        );

        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('getModuleSetting'));
        $oModule->expects($this->any())->method('getModuleSetting')
            ->will($this->returnValue(true));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);
    }


    /**
     * `getPasswordPolicy` returns null if init have not run.
     */
    public function testGetPasswordPolicy_initNotRan_returnNull()
    {
        $this->assertNull($this->SUT->getPasswordPolicy());
    }

    /**
     * `getPasswordPolicy` returns `PasswordPolicyModule` object after init.
     */
    public function testGetPasswordPolicy_initRan_returnPasswordPolicyModuleInstance()
    {
        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_init_parent');

        $this->SUT->init();

        $this->assertType('OxpsPasswordPolicyModule', $this->SUT->getPasswordPolicy());
    }


    /**
     * `render` should add Password Policy settings to ViewData array and class parent render.
     */
    public function testRender_addsPasswordPolicySettingsExecutesParent()
    {
        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_render_parent');

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
     * `forgotPassword` should only call parent if no Password Policy module instance set.
     */
    public function testForgotPassword_noModuleInstance_callsParent()
    {
        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_forgotPassword_parent');

        $this->SUT->forgotPassword();
    }

    /**
     * `forgotPassword` should only call parent if unblock if not allowed
     */
    public function testForgotPassword_unblockNotAllowed_callsParent()
    {

        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('getModuleSetting'));
        $oModule->expects($this->once())->method('getModuleSetting')
            ->will($this->returnValue(false));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_forgotPassword_parent');

        $this->SUT->init();
        $this->SUT->forgotPassword();
    }

    /**
     * `forgotPassword` should only call parent if there is no user email param.
     */
    public function testForgotPassword_unblockAllowedNoUserEmail_callsParent()
    {

        // User mock
        $oUser = $this->getMock('oxUser', array('getIdByUserName'));
        $oUser->expects($this->once())->method('getIdByUserName')
            ->with($this->equalTo(null))
            ->will($this->returnValue(false));

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_forgotPassword_parent');

        $this->SUT->init();
        $this->SUT->forgotPassword();
    }

    /**
     * `forgotPassword` should only call parent if user load fails.
     */
    public function testForgotPassword_unblockAllowedUserLoadFails_callsParent()
    {

        modConfig::setParameter('lgn_usr', 'user@example.com');

        // User mock
        $oUser = $this->getMock('oxUser', array('getIdByUserName', 'load'));
        $oUser->expects($this->once())->method('getIdByUserName')
            ->with($this->equalTo('user@example.com'))
            ->will($this->returnValue('bad_oxid'));
        $oUser->expects($this->once())->method('load')
            ->with($this->equalTo('bad_oxid'))
            ->will($this->returnValue(false));

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_forgotPassword_parent');

        $this->SUT->init();
        $this->SUT->forgotPassword();
    }

    /**
     * `forgotPassword` should only call parent if user is active.
     */
    public function testForgotPassword_unblockAllowedUserActive_callsParent()
    {

        modConfig::setParameter('lgn_usr', 'user@example.com');

        // User mock
        $oUser = $this->getMock('oxUser', array('getIdByUserName', 'load'));
        $oUser->expects($this->once())->method('getIdByUserName')->with($this->equalTo('user@example.com'))
            ->will($this->returnValue('good_oxid'));
        $oUser->expects($this->once())->method('load')->with($this->equalTo('good_oxid'))
            ->will($this->returnValue(true));
        $oUser->oxuser__oxactive = new oxField(true);

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_forgotPassword_parent');

        $this->SUT->init();
        $this->SUT->forgotPassword();
    }

    /**
     * `forgotPassword` should only call parent if user is active.
     */
    public function testForgotPassword_unblockAllowedUserBlocked_unblocksUserThenBlocksAgain()
    {

        modConfig::setParameter('lgn_usr', 'user@example.com');

        // User mock
        $oUser = $this->getMock('oxUser', array('getIdByUserName', 'load', 'save'));
        $oUser->expects($this->once())->method('getIdByUserName')->with($this->equalTo('user@example.com'))
            ->will($this->returnValue('good_oxid'));
        $oUser->expects($this->exactly(2))->method('load')->with($this->equalTo('good_oxid'))
            ->will($this->returnValue(true));
        $oUser->oxuser__oxactive = new oxField(false);
        $oUser->expects($this->exactly(2))->method('save');

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_forgotPassword_parent');

        $this->SUT->init();
        $this->SUT->forgotPassword();
    }


    /**
     * `updatePassword` only calls parent id Password Policy module instance not set.
     */
    public function testUpdatePassword_moduleInstanceNotSet_onlyClassParent()
    {
        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword', 'getModuleSetting'));
        $oModule->expects($this->never())->method('validatePassword');
        $oModule->expects($this->never())->method('getModuleSetting');

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_updatePassword_parent');

        $this->SUT->updatePassword();
    }

    /**
     * `updatePassword` returns false if password validation fails.
     */
    public function testUpdatePassword_invalidPassword_returnsFalse()
    {
        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword', 'getModuleSetting'));
        $oModule->expects($this->once())->method('validatePassword')->will($this->returnValue('ERR'));
        $oModule->expects($this->never())->method('getModuleSetting');

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->never())->method('_oxpsPasswordPolicyForgotPwd_updatePassword_parent');

        $this->SUT->init();
        $this->assertFalse($this->SUT->updatePassword());
    }

    /**
     * `updatePassword` should call parent if password is valid and unblock is not allowed.
     */
    public function testUpdatePassword_validPasswordUnblockNotAllowed_justCallParent()
    {
        // Password policy module mock
        $this->_updatePassword_moduleMock(false);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_updatePassword_parent');

        $this->SUT->init();
        $this->SUT->updatePassword();
    }

    /**
     * `updatePassword` should call parent if password is valid and got no uid value.
     */
    public function testUpdatePassword_validPasswordNoUserId_justCallParent()
    {
        // Password policy module mock
        $this->_updatePassword_moduleMock();

        // User mock
        $oUser = $this->getMock('oxUser', array('loadUserByUpdateId', 'getId'));
        $oUser->expects($this->once())->method('loadUserByUpdateId')->with($this->equalTo(null))
            ->will($this->returnValue(false));
        $oUser->expects($this->never())->method('getId');

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_updatePassword_parent');

        $this->SUT->init();
        $this->SUT->updatePassword();
    }

    /**
     * `updatePassword` should call parent if password is valid and user found, but password update failed.
     */
    public function testUpdatePassword_validPasswordUserFoundUpdateFailed_justCallParent()
    {
        modConfig::setParameter('uid', '123');

        // Password policy module mock
        $this->_updatePassword_moduleMock();

        // User mock
        $oUser = $this->getMock('oxUser', array('loadUserByUpdateId', 'getId', 'load'));
        $oUser->expects($this->once())->method('loadUserByUpdateId')->with($this->equalTo('123'))
            ->will($this->returnValue(true));
        $oUser->expects($this->once())->method('getId')->will($this->returnValue('good_oxid'));
        $oUser->expects($this->never())->method('load');

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_updatePassword_parent')
            ->will($this->returnValue('err'));

        $this->SUT->init();
        $this->SUT->updatePassword();
    }

    /**
     * `updatePassword` should unblock the user and call parent on: password valid; user found, password update success.
     */
    public function testUpdatePassword_validPasswordUserFoundUpdateSuccess_UnblocksUserCallParent()
    {
        modConfig::setParameter('uid', '123');

        // Password policy module mock
        $this->_updatePassword_moduleMock();

        // User mock
        $oUser = $this->getMock('oxUser', array('loadUserByUpdateId', 'getId', 'load', 'save'));
        $oUser->expects($this->once())->method('loadUserByUpdateId')->with($this->equalTo('123'))
            ->will($this->returnValue(true));
        $oUser->expects($this->once())->method('getId')->will($this->returnValue('good_oxid'));
        $oUser->expects($this->once())->method('load')->will($this->returnValue(true));
        $oUser->expects($this->once())->method('save');

        oxTestModules::addModuleObject("oxUser", $oUser);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyForgotPwd_updatePassword_parent')
            ->will($this->returnValue('forgotpwd?success=1'));

        $this->SUT->init();
        $this->SUT->updatePassword();
    }


    /**
     * Default Password Policy module mock for `updatePassword`
     *
     * @param bool $blSettingReturns
     */
    protected function _updatePassword_moduleMock($blSettingReturns = true)
    {
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword', 'getModuleSetting'));
        $oModule->expects($this->once())->method('validatePassword')->will($this->returnValue(''));
        $oModule->expects($this->once())->method('getModuleSetting')->will($this->returnValue($blSettingReturns));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);
    }
}
