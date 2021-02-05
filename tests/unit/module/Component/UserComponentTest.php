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

use oxpspasswordpolicyattempt;

/**
 * Tests for "OxpsPasswordPolicyUser" class
 */
class Unit_Module_Components_OxpsPasswordPolicyUserTest extends OxidTestCase
{

    /**
     * @var OxpsPasswordPolicyUser
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

        // Default SUT mock
        $this->SUT = $this->getMock(
            'OxpsPasswordPolicyUser',
            array(
                '_oxpsPasswordPolicyUser_init_parent',
                '_oxpsPasswordPolicyUser_login_parent',
                '_oxpsPasswordPolicyUser_createUser_parent',
                '_redirectBlockedUser',
                'getLoginStatus',
                'getConfig',
            )
        );

        $this->SUT->expects($this->any())->method('_oxpsPasswordPolicyUser_init_parent')
            ->will($this->returnValue(null));
        $this->SUT->expects($this->any())->method('_oxpsPasswordPolicyUser_login_parent')
            ->will($this->returnValue('login_parent'));
        $this->SUT->expects($this->any())->method('_oxpsPasswordPolicyUser_createUser_parent')
            ->will($this->returnValue('create_user_parent'));
        $this->SUT->expects($this->any())->method('_redirectBlockedUser')->will($this->returnValue(null));

        // Config mock inception
        $oConfig = $this->getMock('oxConfig', array('getShopConfVar'));
        $oConfig->expects($this->any())->method('getShopConfVar')->will($this->returnValue(5));
        $this->SUT->expects($this->any())->method('getConfig')->will($this->returnValue($oConfig));

        // User and attempt mocks
        oxTestModules::addModuleObject("oxUser", new OxpsPasswordPolicyUser_User_Mock());
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
        $this->SUT->init();

        $this->assertType('OxpsPasswordPolicyModule', $this->SUT->getPasswordPolicy());
    }


    /**
     * `login` simply calls parent if no username got in "lgn_usr".
     */
    public function testLogin_noGetParam_returnsParentCallResults()
    {
        $this->SUT->init();

        $this->assertEquals('login_parent', $this->SUT->login());
    }

    /**
     * `login` simply calls parent if username is invalid.
     */
    public function testLogin_nonExistingUsername_returnsParentCallResults()
    {
        modConfig::setParameter('lgn_usr', 'foo');

        $this->SUT->init();

        $this->assertEquals('login_parent', $this->SUT->login());
    }

    /**
     * `login` simply calls parent if user load fails.
     */
    public function testLogin_userLoadFailed_returnsParentCallResults()
    {
        modConfig::setParameter('lgn_usr', 'bad_username');

        $this->SUT->init();

        $this->assertEquals('login_parent', $this->SUT->login());
    }

    /**
     * `login` redirects user to "user blocked" page if user is valid but disabled.
     */
    public function testLogin_userIsBlocked_redirectsToBlockPage()
    {
        modConfig::setParameter('lgn_usr', 'good_username_disabled_user');

        $this->SUT->expects($this->once())->method('_redirectBlockedUser')->will($this->returnValue(null));

        $this->SUT->init();
        $this->SUT->login();
    }

    /**
     * `login` executes parent logic if user is logged in.
     */
    public function testLogin_userLoggedIn_cleansAttemptsReturnsParentCallResults()
    {
        modConfig::setParameter('lgn_usr', 'good_username');

        // Mock user logged in
        $this->SUT->expects($this->once())->method('getLoginStatus')->will($this->returnValue(1));

        // Attempt mock expects `clean` to run
        $oAttempt = $this->getMock('OxpsPasswordPolicyAttempt', array('log', 'maximumReached', 'clean'));
        $oAttempt->expects($this->once())->method('clean');

        oxTestModules::addModuleObject("OxpsPasswordPolicyAttempt", $oAttempt);

        $this->SUT->init();
        $this->SUT->login();
    }

    /**
     * `login` logs attempt if user login failed and executes parent logic while maximum attempts not reached.
     */
    public function testLogin_maxAttemptsNotReached_logsAttemptReturnsParentCallResults()
    {
        modConfig::setParameter('lgn_usr', 'good_username');

        // Mock user not logged in
        $this->SUT->expects($this->once())->method('getLoginStatus')->will($this->returnValue(2));

        // Attempt mock expects `log` and `maximumReached` to run
        $oAttempt = $this->getMock('OxpsPasswordPolicyAttempt', array('log', 'maximumReached', 'clean'));
        $oAttempt->expects($this->once())->method('log');
        $oAttempt->expects($this->once())->method('maximumReached')->will($this->returnValue(false));

        oxTestModules::addModuleObject("OxpsPasswordPolicyAttempt", $oAttempt);

        $this->SUT->init();
        $this->SUT->login();
    }

    /**
     * `login` redirect user to "user blocked" page if maximum login attempts reached.
     */
    public function testLogin_maxAttemptsReached_redirectsToBlockedPage()
    {
        modConfig::setParameter('lgn_usr', 'good_username');

        // Mock user not logged in
        $this->SUT->expects($this->once())->method('getLoginStatus')->will($this->returnValue(2));

        // Attempt mock expects `log` and `maximumReached` to run
        $oAttempt = $this->getMock('OxpsPasswordPolicyAttempt', array('log', 'maximumReached', 'clean'));
        $oAttempt->expects($this->once())->method('log');
        $oAttempt->expects($this->once())->method('maximumReached')->will($this->returnValue(true));

        oxTestModules::addModuleObject("OxpsPasswordPolicyAttempt", $oAttempt);

        $this->SUT->expects($this->once())->method('_redirectBlockedUser')->will($this->returnValue(null));

        $this->SUT->init();
        $this->SUT->login();
    }


    /**
     * `createUser` should return call parent if Password Policy module instance not set.
     */
    public function testCreateUser_moduleInstanceNotSet_callsParent()
    {

        // Module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword'));
        $oModule->expects($this->never())->method('validatePassword');

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->createUser();
    }

    /**
     * `createUser` should call parent if there is no password posted.
     */
    public function testCreateUser_noParam_validationFailReturnFalse()
    {

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyUser_createUser_parent');

        $this->SUT->init();
        $this->SUT->createUser();
    }

    /**
     * `createUser` should call parent if validation passed.
     */
    public function testCreateUser_passwordIsValid_callParent()
    {
        modConfig::setParameter('lgn_pwd', 'veryGOOD!*pass-WORD');

        // Module mock
        $oModule = $this->getMock('OxpsPasswordPolicyModule', array('validatePassword'));
        $oModule->expects($this->once())->method('validatePassword')
            ->with($this->equalTo('veryGOOD!*pass-WORD'))->will($this->returnValue(''));

        oxTestModules::addModuleObject("OxpsPasswordPolicyModule", $oModule);

        $this->SUT->expects($this->once())->method('_oxpsPasswordPolicyUser_createUser_parent');

        $this->SUT->init();
        $this->SUT->createUser();
    }
}

/**
 * User mock.
 */
class OxpsPasswordPolicyUser_User_Mock extends oxUser
{

    /**
     * @var string User OXID mock storage.
     */
    protected $_sUserOxid = '';


    /**
     * Mock setup.
     *
     * @param string|null $sUserOxid
     */
    function __construct($sUserOxid = null)
    {
        if (!is_null($sUserOxid) and is_string($sUserOxid)) {
            $this->_sUserOxid = $sUserOxid;
        }
    }


    /**
     * Overridden method for mocking.
     *
     * @param string $sUsername
     * @return string
     */
    public function getIdByUserName($sUsername)
    {
        if ($sUsername == 'good_username_disabled_user') {
            $this->oxuser__oxactive = new oxField(false);
            return 'good_oxid';
        } elseif ($sUsername == 'good_username') {
            $this->oxuser__oxactive = new oxField(true);
            return 'good_oxid';
        } elseif ($sUsername == 'bad_username') {
            return 'bad_oxid';
        }

        return '';
    }

    /**
     * Overridden method for mocking.
     *
     * @param string $sUserOxid
     * @return bool
     */
    public function load($sUserOxid)
    {
        if ($sUserOxid == 'good_oxid') {
            $this->_sUserOxid = $sUserOxid;
            return true;
        }

        return false;
    }

    /**
     * Overridden method for mocking.
     *
     * @return string
     */
    public function getId()
    {
        return $this->_sUserOxid;
    }

    /**
     * Overridden method for mocking.
     *
     * @return bool
     */
    public function save()
    {
        return true;
    }
}

/**
 * Attempt model mock.
 */
class OxpsPasswordPolicyUser_Attempt_Mock extends OxpsPasswordPolicyAttempt
{
    /**
     * Overridden method for mocking.
     *
     * @param object $oUser
     */
    public function log()
    {
    }
}

/**
 * oxUtilsView mock to collect and get errors
 */
class oxUtilsViewMock extends oxUtilsView
{

    /**
     * @var string Error storage
     */
    protected $_sError = '';


    /**
     * Get error code stored on mocking.
     *
     * @param string
     */
    public function __getMockedError()
    {
        return $this->_sError;
    }

    /**
     * Overridden method for mocking error storage.
     *
     * @param string $sError
     * @param mixed $mArg1
     * @param mixed $mArg2
     * @return mixed
     */
    public function addErrorToDisplay($sError, $mArg1 = false, $mArg2 = true)
    {
        $this->_sError = $sError;
    }
}
