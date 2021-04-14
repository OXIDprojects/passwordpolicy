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

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Model\BaseModel;
use OxidEsales\Eshop\Core\DatabaseProvider;

/**
 * Password policy config helpers used in controllers mostly
 */
class PasswordPolicyViewConfig extends PasswordPolicyViewConfig_parent
{
    public function getJsonPasswordPolicySettings(): string
    {
        $config = Registry::get(PasswordPolicyConfig::class);
        $array = [];
        $array['goodPasswordLength'] = $config->getGoodPasswordLength();
        $array['minPasswordLength'] = $this->getPasswordLength();
        $array['digits'] = $config->getPasswordNeedDigits();
        $array['special'] = $config->getPasswordNeedSpecialCharacter();
        $array['lowercase'] = $config->getPasswordNeedLowerCase();
        $array['uppercase'] = $config->getPasswordNeedUpperCase();
        $res = json_encode($array, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
        if ($res === false) {
            $error = json_last_error_msg();
            throw new \Exception("Password policy configuration broken? - Cloud not convert to JSON: $error");
        }
        return $res;
    }
}
