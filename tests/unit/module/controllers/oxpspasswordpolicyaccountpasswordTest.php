<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @category  tests
 * @package   passwordpolicy
 * @author    OXID Professional services
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2012
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
            '_oxpsPasswordPolicyAccountPassword_init_parent',
            '_oxpsPasswordPolicyAccountPassword_render_parent',
            '_oxpsPasswordPolicyAccountPassword_changePassword_parent'
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
    public function testGetPasswordPolicy_initRan_returnPasswordPolicyModuleInstance()
    {
        $this->SUT->init();

        $this->assertType('OxpsPasswordPolicyModule', $this->SUT->getPasswordPolicy());
    }


    /**
     * `render` should add Password Policy settings to ViewData array and call parent
     */
    public function testRender_addPasswordPolicySettingsCallParent()
    {
        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyAccountPassword_render_parent');

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
    public function testChangePassword_noModuleInstance_callParent()
    {
        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyAccountPassword_changePassword_parent');

        $this->SUT->changePassword();
    }

    /**
     * `changePassword` should return false if password is invalid or empty
     */
    public function testChangePassword_invalidPassword_returnFalse()
    {
        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword'));
        $oModule->expects($this->once())->method('validatePassword')->will($this->returnValue('ERR'));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->never())->method('_oxpsPasswordPolicyAccountPassword_changePassword_parent');

        $this->SUT->init();
        $this->assertFalse($this->SUT->changePassword());
    }

    /**
     * `changePassword` should call parent if password is valid
     */
    public function testChangePassword_passwordIsValid_callParent()
    {
        modConfig::getInstance()->setParameter('password_new', 'abcDEFG_123-pass');

        // Password policy module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword'));
        $oModule->expects($this->once())->method('validatePassword')
            ->with($this->equalTo('abcDEFG_123-pass'))->will($this->returnValue(''));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyAccountPassword_changePassword_parent');

        $this->SUT->init();
        $this->SUT->changePassword();
    }
}
