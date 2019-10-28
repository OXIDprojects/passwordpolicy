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
 * Tests for "OxpsPasswordPolicyModule" class
 */
class Unit_Module_Components_OxpsPasswordPolicyModuleTest extends OxidTestCase
{

    /**
     * @var OxpsPasswordPolicyModule
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

        $this->SUT = oxNew('OxpsPasswordPolicyModule');

        // Set default oxConfig mock
        oxRegistry::set("oxConfig", new oxConfigMock());
    }


    /**
     * `getModuleId` always returns Password Policy module ID: 'oxpspasswordpolicy'.
     */
    public function testGetModuleId_always_returnsModuleId()
    {
        $this->assertEquals('oxpspasswordpolicy', $this->SUT->getModuleId());
    }


    /**
     * `getShopConfVar` returns null for non Password Policy settings.
     */
    public function testGetShopConfVar_nameIsSomeSetting_returnsNull()
    {
        $this->assertNull($this->SUT->getShopConfVar('dDefaultVAT'));
    }

    /**
     * `getShopConfVar` returns Password Policy module config values.
     */
    public function testGetShopConfVar_nameIsModuleSetting_returnsConfigValue()
    {
        $this->assertNotNull($this->SUT->getShopConfVar('iMaxAttemptsAllowed'));
    }

    /**
     * `getShopConfVar` works same as oxConfig::getShopConfVar when calling the module config params.
     */
    public function testGetShopConfVar_nameIsModuleSetting_returnsSameAsInOxConfig()
    {
        $this->assertEquals(
            $this->SUT->getShopConfVar('iMaxPasswordLength'),
            oxConfig::getInstance()->getShopConfVar('iMaxPasswordLength', null, 'oxpspasswordpolicy')
        );
    }


    /**
     * `getModuleSettings` should return only the names of the module settings if argument is true
     */
    public function testGetModuleSettings_argumentIsTrue_returnsModuleSettingsNames()
    {
        $this->assertEquals($this->_getModuleSettingsNames(), $this->SUT->getModuleSettings(true));
    }

    /**
     * `getModuleSettings` should return all Password Policy settings if there are no arguments.
     */
    public function testGetModuleSettings_noArgument_returnsAllModuleSettings()
    {
        $aExpectedSettings = $this->_getModuleSettingsNames();
        $aSettings = $this->SUT->getModuleSettings();

        foreach ($aSettings as $sName => $mValue) {
            $this->assertTrue(in_array($sName, $aExpectedSettings));
        }
    }

    /**
     * `getModuleSettings` should return an array for 'aPasswordRequirements', positive integers for other settings.
     */
    public function testGetModuleSettings_noArgument_returnsCorrectTypes()
    {
        $aSettings = $this->SUT->getModuleSettings();

        foreach ($aSettings as $sName => $mValue) {
            if ($sName == 'aPasswordRequirements') {
                $this->assertType('array', $mValue);
                $this->assertEquals(3, count($mValue));
                $this->assertArrayHasKey('digits', $mValue);
                $this->assertArrayHasKey('capital', $mValue);
                $this->assertArrayHasKey('special', $mValue);
            } elseif ($sName == 'blAllowUnblock') {
                $this->assertType('boolean', $mValue);
            } else {
                $this->assertType('integer', $mValue);
                $this->assertGreaterThan(0, $mValue);
            }
        }
    }


    /**
     * `getModuleSetting` returns null if argument is invalid or not from the module.
     */
    public function testGetModuleSetting_invalidArgument_returnsNull()
    {
        $aInvalidArguments = array(0, '', null, false, array(), 1, 'dDefaultVAT');

        foreach ($aInvalidArguments as $mValue) {
            $this->assertNull($this->SUT->getModuleSetting($mValue));
        }
    }


    /**
     * `GetEncoding` returns one of available system encoding values.
     */
    public function testGetEncoding_always_returnOneOfSystemEncodings()
    {
        $this->assertTrue(in_array($this->SUT->getEncoding(), array('UTF-8', 'ISO-8859-15')));
    }


    /**
     * `validatePassword` should return errors for invalid passwords.
     */
    public function testValidatePassword_wrongArgumentType_passwordIsNotAccepted()
    {
        $this->_mockUtilsView();

        // Test wrong or empty passwords
        $aPasswords_wrongTypeOrEmpty = array(
            null, false, 0, '', ' ', array(), new oxStdClass(), function () {
            }
        );

        foreach ($aPasswords_wrongTypeOrEmpty as $mValue) {
            $this->assertNotEquals('', $this->SUT->validatePassword($mValue));
        }
    }

    /**
     * `validatePassword` should return errors for too short or too long passwords.
     */
    public function testValidatePassword_defaultConfig_lengthValidatesCorrectly()
    {
        $this->_mockUtilsView();

        // Enable length validation only
        $this->SUT->getConfig()->__mockPasswordRequirements(false, false, false);

        $aSettings = $this->SUT->getModuleSettings();

        // Test different length lowercase letters passwords
        $aPasswords_lettersOnly = array(
            'a', 'ab', 'abc', 'abcd', 'abcde', 'abcdea', 'abcdeab', 'abcdeabc', 'abcdeabcd',
            'abcdeabcde', 'abcdeabcdea', 'abcdeabcdeab', 'abcdeabcdeabc',
            'abcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdeabcdea'
        );

        foreach ($aPasswords_lettersOnly as $sValue) {
            $iLength = mb_strlen($sValue, 'UTF-8');

            if ($iLength < $aSettings['iMinPasswordLength']) {
                $this->assertEquals('ERROR_MESSAGE_PASSWORD_TOO_SHORT', $this->SUT->validatePassword($sValue));
            } elseif ($iLength > $aSettings['iMaxPasswordLength']) {
                $this->assertEquals(
                    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG',
                    $this->SUT->validatePassword($sValue));
            }
        }
    }

    /**
     * `validatePassword` should require digits if this is set in configuration and should pass if there are digits.
     */
    public function testValidatePassword_digitsRequired_ValidatesCorrectly()
    {
        $this->_mockUtilsView();

        // Enable length validation only
        $this->SUT->getConfig()->__mockPasswordRequirements(true, false, false);

        $this->assertEquals(
            'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS',
            $this->SUT->validatePassword('abcdefgh')
        );
        $this->assertEquals('', $this->SUT->validatePassword('abcdef5gh'));
    }

    /**
     * `validatePassword` should require capital letters if this is set in configuration and
     *  should pass if there are digits.
     */
    public function testValidatePassword_capitalRequired_ValidatesCorrectly()
    {
        $this->_mockUtilsView();

        // Enable capital chars validation only
        $this->SUT->getConfig()->__mockPasswordRequirements(false, true, false);

        $this->assertEquals(
            'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESCAPITAL',
            $this->SUT->validatePassword('abc5defgh')
        );
        $this->assertEquals('', $this->SUT->validatePassword('abcFdefgh'));
    }

    /**
     * `validatePassword` should require special chars if this is set in configuration and
     *  should pass if there are digits.
     */
    public function testValidatePassword_specialRequired_ValidatesCorrectly()
    {
        $this->_mockUtilsView();

        // Enable special chars validation only
        $this->SUT->getConfig()->__mockPasswordRequirements(false, false, true);

        $this->assertEquals(
            'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL',
            $this->SUT->validatePassword('abcdRe9fgh')
        );
        $this->assertEquals('', $this->SUT->validatePassword('abcde_fgh'));
    }

    /**
     * `validatePassword` should require all set rules and pass if all are satisfied.
     */
    public function testValidatePassword_allRequirementsSet_ValidatesCorrectly()
    {
        $this->_mockUtilsView();

        // Enable all validation rules
        $this->SUT->getConfig()->__mockPasswordRequirements(true, true, true);

        $aPasswords_notFullyStrong = array(
            'a', 'A', '1', '_', 'abcedf', 'abcde1', 'abcdE1'
        );

        foreach ($aPasswords_notFullyStrong as $sValue) {
            $this->assertNotEquals('', $this->SUT->validatePassword($sValue));
        }

        $this->assertEquals('', $this->SUT->validatePassword('abcD1_'));
    }


    /**
     * `getPasswordRequirementsOptions` returns not empty array with some options.
     */
    public function testGetPasswordRequirementsOptions_always_returnNotEmptyArray()
    {
        $this->assertGreaterThan(0, count($this->SUT->getPasswordRequirementsOptions()));
    }


    /**
     * `validatePositiveInteger` should not pass invalid types or values
     */
    public function testValidatePositiveInteger_invalidValuesGiven_returnsFalse()
    {
        $aInvalidValues = array(
            false, true, null, 0, -1, 0.01, 10.0, 1.5, -0x12, array(), array(1), new oxStdClass(),
            'hi', '', '1', '01', '10', '-1', ' ', "\r\n", function () {
            }
        );

        foreach ($aInvalidValues as $mValue) {
            $this->assertFalse($this->SUT->validatePositiveInteger($mValue));
        }
    }

    /**
     * `validatePositiveInteger` should pass positive decimal integers
     */
    public function testValidatePositiveInteger_positiveDecIntGiven_returnsTrue()
    {
        $aValidValues = array(1, 10, 1000000, 100000000);

        foreach ($aValidValues as $iValue) {
            $this->assertTrue($this->SUT->validatePositiveInteger($iValue));
        }
    }

    /**
     * `validatePositiveInteger` should validate min, max ranges correctly
     */
    public function testValidatePositiveInteger_minMaxRangeGiven_validatesCorrectly()
    {
        $iMin = 10;
        $iMax = 100;

        $this->assertFalse($this->SUT->validatePositiveInteger(9, $iMin, $iMax));
        $this->assertTrue($this->SUT->validatePositiveInteger(10, $iMin, $iMax));
        $this->assertTrue($this->SUT->validatePositiveInteger(50, $iMin, $iMax));
        $this->assertTrue($this->SUT->validatePositiveInteger(100, $iMin, $iMax));
        $this->assertFalse($this->SUT->validatePositiveInteger(1000000, $iMin, $iMax));
    }


    /**
     * Get all available module settings names.
     *
     * @return array
     */
    private function _getModuleSettingsNames()
    {
        return array(
            'iMaxAttemptsAllowed', 'iTrackingPeriod', 'blAllowUnblock',
            'iMinPasswordLength', 'iGoodPasswordLength', 'iMaxPasswordLength', 'aPasswordRequirements'
        );
    }

    /**
     * Mock `oxUtilsView` method `addErrorToDisplay` for password validation checking
     */
    private function _mockUtilsView()
    {

        // Set oxUtilsView mock
        $oUtilsViewMock = $this->getMock('oxUtilsView', array('addErrorToDisplay'));
        $oUtilsViewMock->expects($this->any())->method('addErrorToDisplay')
            ->with($this->anything(), false, true);

        oxRegistry::set("oxUtilsView", $oUtilsViewMock);
    }
}


/**
 * oxConfig mock class with default params predefined.
 */
class oxConfigMock extends oxConfig
{

    /**
     * @var array Mocked config storage
     */
    protected $_aConfig;

    /**
     * @var bool Should password require digits
     */
    protected $_bPasswordRequiresDigits = true;

    /**
     * @var bool Should password require capital letters
     */
    protected $_bPasswordRequiresCapital = true;

    /**
     * @var bool Should password require special chars
     */
    protected $_bPasswordRequiresSpecial = false;


    /**
     * Mock setup method to set password requirements settings.
     *
     * @param bool $bPasswordRequiresDigits
     * @param bool $bPasswordRequiresCapital
     * @param bool $bPasswordRequiresSpecial
     */
    public function __mockPasswordRequirements($bPasswordRequiresDigits, $bPasswordRequiresCapital,
                                               $bPasswordRequiresSpecial)
    {
        $this->_bPasswordRequiresDigits = $bPasswordRequiresDigits;
        $this->_bPasswordRequiresCapital = $bPasswordRequiresCapital;
        $this->_bPasswordRequiresSpecial = $bPasswordRequiresSpecial;
    }

    /**
     * Overridden method for mocking the settings.
     *
     * @param string $sName
     * @param mixed $mShopId
     * @param mixed $mModuleId
     * @return mixed
     */
    public function getShopConfVar($sName, $mShopId = null, $mModuleId = null)
    {
        if ($mModuleId != 'oxpspasswordpolicy') {
            $config = array('dDefaultVAT' => 21);
        } else {
            $config = array(
                'iMaxAttemptsAllowed' => 3,
                'iTrackingPeriod' => 60,
                'iMinPasswordLength' => 6,
                'iGoodPasswordLength' => 12,
                'iMaxPasswordLength' => 100,
                'aPasswordRequirements' => array(
                    'digits' => $this->_bPasswordRequiresDigits,
                    'capital' => $this->_bPasswordRequiresCapital,
                    'special' => $this->_bPasswordRequiresSpecial
                ),
            );
        }

        return (isset($config[$sName]) ? $config[$sName] : parent::getShopConfVar($sName, $mShopId, $mModuleId));
    }

    /**
     * Overridden method for mocking the settings storage.
     *
     * @param string $sType
     * @param string $sName
     * @param mixed $mValue
     * @param mixed $mShopId
     * @param mixed $mModuleId
     * @return bool
     */
    public function saveShopConfVar($sType, $sName, $mValue, $mShopId = null, $mModuleId = null)
    {
        return true;
    }
}
