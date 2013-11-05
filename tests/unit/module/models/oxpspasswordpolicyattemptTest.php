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
 * Tests for "OxpsPasswordPolicyAttempt" class
 */
class Unit_Module_Models_OxpsPasswordPolicyAttemptTest extends OxidTestCase
{

    /**
     * @var OxpsPasswordPolicyAttempt
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

        $this->SUT = $this->getMock('OxpsPasswordPolicyAttempt', array(
            '_oxpsPasswordPolicyAttempt_construct_parent', 'init',
            '_getAttemptTime', '_getIpAddress', 'assign', 'save',
        ));
    }


    /**
     * `__invoke` should make class callable and be an alias for `log`.
     */
    public function testInvoke_isCallable()
    {
        $this->SUT = $this->getMock('OxpsPasswordPolicyAttempt', array(
            '_oxpsPasswordPolicyAttempt_construct_parent', 'init', 'log'
        ));
        $this->SUT->expects($this->once())->method('log');

        $this->assertTrue(is_callable($this->SUT));

        $oAttempt = $this->SUT;
        $oAttempt();
    }


    /**
     * `getUser` should return null if user was not set.
     */
    public function testGetUser_userNotSet_returnsNull()
    {
        $this->assertNull($this->SUT->getUser());
    }

    /**
     * `setUser` should accept only oxUser objects.
     */
    public function testGetUser_invalidTypeSet_returnPreviouslySetValue()
    {
        $this->SUT->setUser(new oxStdClass());

        $this->assertNull($this->SUT->getUser());
    }

    /**
     * `getUser` should return the user that was set.
     */
    public function testGetUser_userSet_returnsSameUser()
    {
        $oUser = new oxUser();
        $this->SUT->setUser($oUser);

        $this->assertEquals($oUser, $this->SUT->getUser());
    }


    /**
     * `getMaxAttemptsAllowed` return default if nothing set.
     */
    public function testGetMaxAttemptsAllowed_nothingSet_returnsDefault()
    {
        $this->assertEquals(3, $this->SUT->getMaxAttemptsAllowed());
    }

    /**
     * `getMaxAttemptsAllowed` return previously set value if wrong type was tried to set.
     */
    public function testGetMaxAttemptsAllowed_wrongTypesSet_returnsUnchangedValue()
    {
        $iDummy = 5;
        $this->SUT->setMaxAttemptsAllowed($iDummy);

        // Set wrong type
        $this->SUT->setMaxAttemptsAllowed(array('' => null));

        $this->assertEquals($iDummy, $this->SUT->getMaxAttemptsAllowed());
    }

    /**
     * `getMaxAttemptsAllowed` return previously set value if negative value was tried to set.
     */
    public function testGetMaxAttemptsAllowed_invalidValuesSet_returnsUnchangedValue()
    {
        $iDummy = 60;
        $this->SUT->setMaxAttemptsAllowed($iDummy);

        // Set invalid value
        $this->SUT->setMaxAttemptsAllowed(-8);

        $this->assertEquals($iDummy, $this->SUT->getMaxAttemptsAllowed());
    }

    /**
     * `getMaxAttemptsAllowed` return the same value that was set.
     */
    public function testGetMaxAttemptsAllowed_valueSet_returnsSameValue()
    {
        $iDummy = 10;
        $this->SUT->setMaxAttemptsAllowed($iDummy);

        $this->assertEquals($iDummy, $this->SUT->getMaxAttemptsAllowed());
    }


    /**
     * `getTrackingPeriod` return default if nothing set.
     */
    public function testGetTrackingPeriod_nothingSet_returnsDefault()
    {
        $this->assertEquals(60, $this->SUT->getTrackingPeriod());
    }

    /**
     * `getTrackingPeriod` return previously set value if wrong type was tried to set.
     */
    public function testGetTrackingPeriod_wrongTypesSet_returnsUnchangedValue()
    {
        $iDummy = 10;
        $this->SUT->setTrackingPeriod($iDummy);

        // Set wrong type
        $this->SUT->setTrackingPeriod('foo');

        $this->assertEquals($iDummy, $this->SUT->getTrackingPeriod());
    }

    /**
     * `getTrackingPeriod` return previously set value if zero was tried to set.
     */
    public function testGetTrackingPeriod_invalidValuesSet_returnsUnchangedValue()
    {
        $iDummy = 1000;
        $this->SUT->setTrackingPeriod($iDummy);

        // Set invalid value
        $this->SUT->setTrackingPeriod(0);

        $this->assertEquals($iDummy, $this->SUT->getTrackingPeriod());
    }

    /**
     * `getTrackingPeriod` return the same value that was set.
     */
    public function testGetTrackingPeriod_valueSet_returnsSameValue()
    {
        $iDummy = 1;
        $this->SUT->setTrackingPeriod($iDummy);

        $this->assertEquals($iDummy, $this->SUT->getTrackingPeriod());
    }


    /**
     * `log` returns false if no user was set.
     */
    public function testLog_userNotSet_returnsFalse()
    {
        $this->assertFalse($this->SUT->log());
    }

    /**
     * `log` should assign values and save entry if user is set.
     */
    public function testLog_userSet_assignAndSaveEntry()
    {

        $this->SUT->expects($this->once())->method('_getAttemptTime')->will($this->returnValue('2015-01-01 00:00:01'));
        $this->SUT->expects($this->once())->method('_getIpAddress')->will($this->returnValue('1.2.3.4'));
        $this->SUT->expects($this->once())->method('assign')->with($this->equalTo(array(
            'oxuserid' => 'good_oxid',
            'oxpstime' => '2015-01-01 00:00:01',
            'oxpsip' => '1.2.3.4',
        )));
        $this->SUT->expects($this->once())->method('save')->will($this->returnValue(true));

        // User mock
        $oUser = $this->getMock('oxUser', array('getId'));
        $oUser->expects($this->once())->method('getId')->will($this->returnValue('good_oxid'));

        $this->SUT->setUser($oUser);

        $this->assertTrue($this->SUT->log());
    }


    /**
     * `maximumReached` returns false if no user was set.
     */
    public function testMaximumReached_userNotSet_returnsFalse()
    {
        $this->assertFalse($this->SUT->maximumReached());
    }
}
