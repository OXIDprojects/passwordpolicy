<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @category  module
 * @package   passwordpolicy
 * @author    OXID Professional services
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2012
 */

/**
 * Password entry attempts tracking model
 */
class OxpsPasswordPolicyAttempt extends oxBase
{
    /**
     * @var oxUser
     */
    protected $_oUser;

    /**
     * @var integer $_iMaxAttemptsAllowed Maximum number of attempts before user is blocked.
     */
    protected $_iMaxAttemptsAllowed;

    /**
     * @var integer $_iTrackingPeriod A period in minutes to track attempts sequence.
     */
    protected $_iTrackingPeriod;


    public function __construct()
    {

        // Parent call
        $this->_oxpsPasswordPolicyAttempt_construct_parent();

        // Set defaults
        $this->setMaxAttemptsAllowed(3);
        $this->setTrackingPeriod(60);

        $this->init('oxpspasswordpolicy_attempt');
    }

    /**
     * A magic method that makes the class callable.
     * This is an alias for log function.
     */
    public function __invoke()
    {
        return $this->log();
    }


    /**
     * Get oxUser.
     *
     * @return oxUser
     */
    public function getUser()
    {
        return $this->_oUser;
    }

    /**
     * Set oxUser.
     *
     * @param object $oUser
     * @return null|void
     */
    public function setUser($oUser)
    {
        if ($oUser instanceof oxUser) {
            $this->_oUser = $oUser;
        }
    }

    /**
     * Get maximum allowed attempts value.
     *
     * @return int
     */
    public function getMaxAttemptsAllowed()
    {
        return $this->_iMaxAttemptsAllowed;
    }

    /**
     * Set maximum allowed attempts value.
     *
     * @param int $iMaxAttemptsAllowed
     */
    public function setMaxAttemptsAllowed($iMaxAttemptsAllowed)
    {
        if ($this->_isPositiveInteger($iMaxAttemptsAllowed)) {
            $this->_iMaxAttemptsAllowed = $iMaxAttemptsAllowed;
        }
    }

    /**
     * Get tracking period value.
     *
     * @return int
     */
    public function getTrackingPeriod()
    {
        return $this->_iTrackingPeriod;
    }

    /**
     * Set tracking period value.
     *
     * @param int $iTrackingPeriod
     */
    public function setTrackingPeriod($iTrackingPeriod)
    {
        if ($this->_isPositiveInteger($iTrackingPeriod)) {
            $this->_iTrackingPeriod = $iTrackingPeriod;
        }
    }

    /**
     * Log attempt to database.
     * Works only if user is set.
     *
     * @return boolean
     */
    public function log()
    {
        $sUserOxid = $this->_getUserOxid();

        if (!empty($sUserOxid)) {
            $this->assign(array(
                'oxuserid' => $sUserOxid,
                'oxpstime' => $this->_getAttemptTime(),
                'oxpsip' => $this->_getIpAddress(),
            ));

            return (bool)$this->save();
        }

        return false;
    }

    /**
     * Check if user has not reached maximum attempts for defined period of time.
     *
     * @return boolean
     */
    public function maximumReached()
    {
        $sUserOxid = $this->_getUserOxid();

        if (!empty($sUserOxid)) {
            // @codeCoverageIgnoreStart
            // Not covering database queries

            $sQuery = "SELECT `OXID` FROM `%s`
                WHERE `OXUSERID` = %s AND `OXPSTIME` >= %s
                HAVING COUNT(`OXID`) >= %d";

            $mResults = oxDb::getDb()->execute(sprintf($sQuery,
                getViewName('oxpspasswordpolicy_attempt'),
                oxDb::getDb()->quote($sUserOxid),
                oxDb::getDb()->quote($this->_getTimeMargin()),
                $this->getMaxAttemptsAllowed()
            ));

            return !empty($mResults->fields[0]);
            // @codeCoverageIgnoreEnd
        }

        return false;
    }

    /**
     * Clean older attempt log entries.
     * If user is set, only related entries will be removed.
     *
     * @return boolean.
     */
    public function clean()
    {
        // @codeCoverageIgnoreStart
        // Not covering database queries

        $sUserOxid = $this->_getUserOxid();

        if (!empty($sUserOxid)) {

            // Clause to delete only defined user attempts
            $sUserClause = "`OXUSERID` = " . oxDb::getDb()->quote($sUserOxid);
        } else {

            // Clause to delete only expired entries (older than tracking period)
            $sUserClause = "`OXPSTIME` < " . oxDb::getDb()->quote($this->_getTimeMargin());
        }

        $sQuery = "DELETE FROM `%s` WHERE %s";

        return (bool)oxDb::getDb()->execute(sprintf($sQuery, getViewName('oxpspasswordpolicy_attempt'), $sUserClause));
        // @codeCoverageIgnoreEnd
    }


    /**
     * Validate if value is a positive integer.
     *
     * @param mixed $number
     * @return bool
     */
    protected function _isPositiveInteger($number)
    {
        return (is_integer($number) and ($number > 0));
    }

    /**
     * Get user OXID value.
     * Return NULL if no user is assigned.
     *
     * @return string|null
     */
    protected function _getUserOxid()
    {
        return (is_object($this->_oUser) ? $this->_oUser->getId() : null);
    }

    /**
     * Calculate date-time value in past that is the margin for checking.
     * This is based on tracking period value.
     *
     * @return string Date-time value.
     */
    protected function _getTimeMargin()
    {
        // @codeCoverageIgnoreStart
        // Not covering default php methods

        return date(
            'Y-m-d H:i:s',
            strtotime('now - ' . (int)$this->getTrackingPeriod() . ' minute')
        );
        // @codeCoverageIgnoreEnd
    }

    /**
     * Get current ISO time for an attempt.
     *
     * @return string
     */
    protected function _getAttemptTime()
    {
        // @codeCoverageIgnoreStart
        // Not covering default php method

        return date('Y-m-d H:i:s');
        // @codeCoverageIgnoreEnd
    }

    /**
     * Get client IP address.
     *
     * @return string
     */
    protected function _getIpAddress()
    {
        // @codeCoverageIgnoreStart
        // Not covering default eShop utils

        return ''; // IP address storage is illegal in Germany
        // @codeCoverageIgnoreEnd
    }


    /**
     * Parent `__construct` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function _oxpsPasswordPolicyAttempt_construct_parent()
    {
        // @codeCoverageIgnoreStart
        return parent::__construct();
        // @codeCoverageIgnoreEnd
    }
}
