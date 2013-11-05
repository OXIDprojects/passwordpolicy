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
 * Tests for "Admin_OxpsPasswordPolicy" class.
 */
class Unit_Module_Controllers_Admin_OxpsPasswordPolicyTest extends OxidTestCase
{

    /**
     * @var Admin_OxpsPasswordPolicy
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

        $this->SUT = $this->getMock('Admin_OxpsPasswordPolicy', array(
            '_admin_OxpsPasswordPolicy_construct_parent', '_admin_OxpsPasswordPolicy_init_parent',
            '_admin_OxpsPasswordPolicy_render_parent',
        ));
    }


    /**
     * `init` should call parent init and set Password Policy module instance.
     */
    public function testInit_callsParentAndSetsModuleInstance()
    {
        $this->SUT->expects($this->once())->method('_admin_OxpsPasswordPolicy_init_parent');

        $this->SUT->init();

        $this->assertNotNull($this->SUT->getPasswordPolicy());
    }


    /**
     * `getPasswordPolicy` returns null if nothing set.
     */
    public function testGetPasswordPolicy_nothingSet_returnNull()
    {
        $this->assertNull($this->SUT->getPasswordPolicy());
    }

    /**
     * `getPasswordPolicy` returns `PasswordPolicyModule` object after init.
     */
    public function testGetPasswordPolicy_passwordPolicySet_returnPasswordPolicyModuleInstance()
    {
        $this->SUT->setPasswordPolicy();
        $this->assertType('OxpsPasswordPolicyModule', $this->SUT->getPasswordPolicy());
    }


    /**
     * `render` should add Password Policy settings to ViewData array.
     */
    public function testRender_addsPasswordPolicySettingsReturnsParent()
    {
        $this->SUT->expects($this->once())->method('_admin_OxpsPasswordPolicy_render_parent')
            ->will($this->returnValue('parent_render'));

        $aConfigKeys = array(
            'iMaxAttemptsAllowed', 'iTrackingPeriod', 'blAllowUnblock',
            'iMinPasswordLength', 'iGoodPasswordLength', 'iMaxPasswordLength', 'aPasswordRequirements'
        );

        $this->SUT->init();
        $sRenderResults = $this->SUT->render();
        $aViewData = $this->SUT->getViewData();

        foreach ($aConfigKeys as $sKey) {
            $this->assertArrayHasKey($sKey, $aViewData);
        }

        $this->assertEquals('parent_render', $sRenderResults);
    }


    /**
     * `save` only saves booleans if parameters are missing, message is always set.
     */
    public function testSave_noParams_savesOnlyBools()
    {
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('saveShopConfVar'));
        $oModule->expects($this->exactly(2))->method('saveShopConfVar');

        $this->SUT->setPasswordPolicy($oModule);
        $this->SUT->save();

        $this->assertArrayHasKey('message', $this->SUT->getViewData());
    }

    /**
     * `save` invalid values should not be saved.
     */
    public function testSave_invalidParams_settingsNotSaved()
    {
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('saveShopConfVar'));
        $oModule->expects($this->exactly(2))->method('saveShopConfVar');

        $sPrefix = 'passwordpolicy_';
        modConfig::setParameter($sPrefix . 'maxattemptsallowed', 0);
        modConfig::setParameter($sPrefix . 'trackingperiod', 0.0);
        modConfig::setParameter($sPrefix . 'minpasswordlength', 4);
        modConfig::setParameter($sPrefix . 'goodpasswordlength', '');
        modConfig::setParameter($sPrefix . 'maxpasswordlength', -2);

        $this->SUT->setPasswordPolicy($oModule);
        $this->SUT->save();
    }

    /**
     * `save` should not save passwords length that do not answer to lengths logic. While valid settings are saved.
     */
    public function testSave_passwordLengthsLogicInvalid_lengthSettingsNotSaved()
    {
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('saveShopConfVar'));
        $oModule->expects($this->exactly(4))->method('saveShopConfVar');

        $sPrefix = 'passwordpolicy_';
        modConfig::setParameter($sPrefix . 'maxattemptsallowed', 5);
        modConfig::setParameter($sPrefix . 'trackingperiod', 100);
        modConfig::setParameter($sPrefix . 'allowunblock', 1);
        modConfig::setParameter($sPrefix . 'minpasswordlength', 4);
        modConfig::setParameter($sPrefix . 'goodpasswordlength', 3);
        modConfig::setParameter($sPrefix . 'maxpasswordlength', 2);

        $this->SUT->setPasswordPolicy($oModule);
        $this->SUT->save();
    }

    /**
     * `save` should not save min password length less than 6. While valid settings are saved.
     */
    public function testSave_minLengthLessThanSix_minLengthNotSaved()
    {
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('saveShopConfVar'));
        $oModule->expects($this->exactly(6))->method('saveShopConfVar');

        $sPrefix = 'passwordpolicy_';
        modConfig::setParameter($sPrefix . 'maxattemptsallowed', 5);
        modConfig::setParameter($sPrefix . 'trackingperiod', 100);
        modConfig::setParameter($sPrefix . 'allowunblock', 1);
        modConfig::setParameter($sPrefix . 'minpasswordlength', 4);
        modConfig::setParameter($sPrefix . 'goodpasswordlength', 12);
        modConfig::setParameter($sPrefix . 'maxpasswordlength', 100);

        $this->SUT->setPasswordPolicy($oModule);
        $this->SUT->save();
    }

    /**
     * `save` save all settings with all valid values.
     */
    public function testSave_allValuesValid_AllSettingsSaved()
    {
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('saveShopConfVar'));
        $oModule->expects($this->exactly(7))->method('saveShopConfVar');

        $sPrefix = 'passwordpolicy_';
        modConfig::setParameter($sPrefix . 'maxattemptsallowed', 5);
        modConfig::setParameter($sPrefix . 'trackingperiod', 100);
        modConfig::setParameter($sPrefix . 'allowunblock', 1);
        modConfig::setParameter($sPrefix . 'minpasswordlength', 8);
        modConfig::setParameter($sPrefix . 'goodpasswordlength', 12);
        modConfig::setParameter($sPrefix . 'maxpasswordlength', 100);
        modConfig::setParameter($sPrefix . 'requirements', array('digits' => 1));

        $this->SUT->setPasswordPolicy($oModule);
        $this->SUT->save();
    }
}
