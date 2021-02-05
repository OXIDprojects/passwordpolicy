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
 * @link          https://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2021
 */

namespace OxidProfessionalServices\PasswordPolicy\Model;

use \OxidEsales\Eshop\Core\Model\BaseModel;
use \OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * Password entry attempts tracking model
 */
class OxpsPasswordPolicyAttempt extends BaseModel
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


    /**
     * OxpsPasswordPolicyAttempt constructor. Initialises the model with the corresponding database table.
     */
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
            $view = getViewName('oxpspasswordpolicy_attempt');
            $sQuery = "SELECT `OXID` FROM `$view`
                WHERE `OXUSERID` = ? AND `OXPSTIME` >= ?
                HAVING COUNT(`OXID`) >= ?";

            $mResults = DatabaseProvider::getDb()->select($sQuery,
                [$sUserOxid, $this->_getTimeMargin(), $this->getMaxAttemptsAllowed()]
            );

            return !empty($mResults->fields[0]);
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
            $sUserClause = "`OXUSERID` = " . DatabaseProvider::getDb()->quote($sUserOxid);
        } else {

            // Clause to delete only expired entries (older than tracking period)
            $sUserClause = "`OXPSTIME` < " . DatabaseProvider::getDb()->quote($this->_getTimeMargin());
        }

        $sQuery = "DELETE FROM `%s` WHERE %s";

        return (bool)DatabaseProvider::getDb()->execute(sprintf($sQuery, getViewName('oxpspasswordpolicy_attempt'), $sUserClause));
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
