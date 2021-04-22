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

declare(strict_types=1);

namespace OxidProfessionalServices\PasswordPolicy\Core;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Registry;use OxidProfessionalServices\PasswordPolicy\Validators\PasswordPolicyValidatorsCollector;

class PasswordPolicyValidator extends PasswordPolicyValidator_parent
{

    /**
     * @param User $user
     * @param string $newPassword
     * @param string $confirmationPassword
     * @param bool $shouldCheckPasswordLength this parameter is ignored, the password policy module always checks the
     * length of passwords because it is important for security
     * @return StandardException|\OxidEsales\EshopCommunity\Core\Exception\StandardException|null
     */
    public function checkPassword($user, $newPassword, $confirmationPassword, $shouldCheckPasswordLength = false)
    {
        $user->loadUserByUpdateId((new \OxidEsales\Eshop\Core\Request)->getRequestEscapedParameter('uid'));
        $username = $user->oxuser__oxusername->value;
        $ex = $this->validatePassword($username, $newPassword);
        if (isset($ex)) {
            return $ex;
        }
        return parent::checkPassword($user, $newPassword, $confirmationPassword, $shouldCheckPasswordLength);
    }

    /**
     * Validate password with password policy rules.
     *
     * @param string $sPassword
     * @return null|StandardException
     */
    public function validatePassword(string $sUsername, string $sPassword): ?StandardException
    {
        $container = $this->getContainer();
        $passwordPolicyValidatorsCollector = $container->get(PasswordPolicyValidatorsCollector::class);
        $sError = $passwordPolicyValidatorsCollector->validate($sUsername, $sPassword);
        if (is_string($sError)) {
            $translateString = Registry::getLang()->translateString($sError);
            $exception = oxNew(UserException::class, $translateString);
            return $this->addValidationError("oxuser__oxpassword", $exception);
        }
        return null;
    }

    /**
     * Min length of password.
     *
     * @return int
     */
    public function getPasswordLength()
    {
        return (int) Registry::getConfig()->getConfigParam(PasswordPolicyConfig::SettingMinPasswordLength, 8);
    }
}
