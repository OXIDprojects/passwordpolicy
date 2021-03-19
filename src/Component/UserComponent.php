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

namespace OxidProfessionalServices\PasswordPolicy\Component;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Application\Model\User;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyModule;
use OxidProfessionalServices\PasswordPolicy\Model\Attempt;

/**
 * Extend user component to intercept login failures
 */
class UserComponent extends UserComponent_parent
{

    /**
     * @var object $passwordPolicy Password policy module instance.
     */
    protected $passwordPolicy;

    /**
     * Overridden init method, that creates password policy module object.
     */
    public function init()
    {
        // Introducing the extension's error page controller here...
        // @Todo: Ensure whitelist name is still valid
        $this->_aAllowedClasses = array_merge(
            $this->_aAllowedClasses,
            [
                'oxpspasswordpolicy'
            ]
        );

        // Parent init call
        $this->oxpsPasswordPolicyUserInitParent();

        $this->setPasswordPolicy();
    }

    /**
     * Set Password Policy instance
     *
     * @param mixed $mPasswordPolicy
     */
    public function setPasswordPolicy($oPasswordPolicy = null)
    {
        $this->passwordPolicy = is_object($oPasswordPolicy) ? $oPasswordPolicy : oxNew(PasswordPolicyModule::class);
    }

    /**
     * @return object Password policy module instance.
     */
    public function getPasswordPolicy()
    {
        return $this->passwordPolicy;
    }

    /**
     * Overridden login method.
     * Calls login attempts handler if user was found.
     */
    public function login()
    {
        // Parent login call
        $mLoginResponse = $this->oxpsPasswordPolicyUserLoginParent();

        $oUser = oxNew(User::class);

        // Try loading user by username
        $iUserId = $oUser->getIdByUserName(Registry::getConfig()->getRequestParameter('lgn_usr'));

        // Continue with login attempts logic only if user id valid and user is loaded
        if (!empty($iUserId) and $oUser->load($iUserId) and $oUser->getId()) {
            $this->handleLoginAttempts($oUser);
        }

        return $mLoginResponse;
    }

    /**
     * Overridden user creation method to add password policy validation.
     *
     * @return mixed
     */
    public function createUser()
    {
        // Validate password using password policy rules
        $oModule = $this->getPasswordPolicy();
        $oConfig = Registry::getConfig();

        if (
            is_object($oModule) and $oConfig->getRequestParameter('lgn_pwd') and
                                    $oModule->validatePassword($oConfig->getRequestParameter('lgn_pwd'))
        ) {
            return false;
        }

        // Parent create user call
        return $this->oxpsPasswordPolicyUserCreateUserParent();
    }


    /**
     * Checks if user must be blocked on login failures;
     *  Tracks login attempts;
     *  Purges attempts logs on login success.
     *
     * @param object $oUser
     */
    protected function handleLoginAttempts($oUser)
    {

        // User object must be valid and loaded
        if (($oUser instanceof oxUser) and $oUser->getId()) {
            // Check user status
            if (empty($oUser->oxuser__oxactive->value)) {
                // Redirect user to block page if he is not active.
                $this->redirectBlockedUser();
                return;
            }

            // Create attempts object and assign user
            $oAttempt = oxNew(Attempt::class);
            $oAttempt->setUser($oUser);
            $oAttempt->setMaxAttemptsAllowed(
                (int)Registry::getConfig()->getShopConfVar('iMaxAttemptsAllowed', null, 'module:oxpspasswordpolicy')
            );
            $oAttempt->setTrackingPeriod(
                (int)Registry::getConfig()->getShopConfVar('iTrackingPeriod', null, 'module:oxpspasswordpolicy')
            );

            if ($this->getLoginStatus() == USER_LOGIN_FAIL) {
                // Log attempts
                $oAttempt->log();

                if ($oAttempt->maximumReached()) {
                    // Block user and redirect to blocked user page
                    $oUser->oxuser__oxactive = new OxidEsales\Eshop\Core\Field(0);
                    $oUser->save();

                    // Redirect user
                    $this->redirectBlockedUser();
                    return;
                }
            } else {
                // Purge all login attempts for the user
                $oAttempt->clean();
            }
        }
    }

    /**
     * Redirect user to "account blocked" page, when the maximum attempts are reached.
     *
     * @return null
     */
    protected function redirectBlockedUser()
    {
        // @codeCoverageIgnoreStart
        // Not covering redirects.

        Registry::getUtils()->redirect(
            Registry::getConfig()->getShopHomeURL() . 'cl=oxpspasswordpolicy',
            false,
            302
        );

        return null;
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `init` call. Method required for mocking.
     *
     * @return null
     */
    protected function oxpsPasswordPolicyUserInitParent()
    {
        // @codeCoverageIgnoreStart
        return parent::init();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `login` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function oxpsPasswordPolicyUserLoginParent()
    {
        // @codeCoverageIgnoreStart
        return parent::login();
        // @codeCoverageIgnoreEnd
    }

    /**
     * Parent `createUser` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function oxpsPasswordPolicyUserCreateUserParent()
    {
        // @codeCoverageIgnoreStart
        return parent::createUser();
        // @codeCoverageIgnoreEnd
    }
}
