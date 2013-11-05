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
 * Tests for "OxpsPasswordPolicyRegister" class
 */
class Unit_Module_Controllers_OxpsPasswordPolicyRegisterTest extends OxidTestCase
{

    /**
     * @var OxpsPasswordPolicyRegister
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

        $this->SUT = $this->getMock('OxpsPasswordPolicyRegister', array(
            '_oxpsPasswordPolicyRegister_init_parent',
            '_oxpsPasswordPolicyRegister_render_parent',
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
     * `getPasswordPolicy` returns `PasswordPolicyModule` object after init.
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
        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyRegister_render_parent');

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
}
