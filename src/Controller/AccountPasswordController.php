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

namespace OxidProfessionalServices\PasswordPolicy\Controller;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyModule;

/**
 * Password policy main controller
 */
class AccountPasswordController extends AccountPasswordController_parent
{
    use ControllerWithPasswordPolicy;

    /**
     * Overridden password changing callback method to add password policy validation.
     *
     * @return mixed
     */
    public function changePassword()
    {
        /** @var oxConfig $oConfig */
        $oConfig = $this->getConfig();
        $oModule = $this->getPasswordPolicy();

        // Validate password using password policy rules
        if (is_object($oModule) and $oModule->validatePassword($oConfig->getRequestParameter('password_new'))) {
            return false;
        }

        // Parent call
        return $this->oxpsPasswordPolicyChangePasswordParent();
    }


    /**
     * Parent `changePassword` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function oxpsPasswordPolicyChangePasswordParent()
    {
        // @codeCoverageIgnoreStart
        return parent::changePassword();
        // @codeCoverageIgnoreEnd
    }
}
