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

/**
 * Metadata version
 */

use OxidEsales\Eshop\Core\InputValidator;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyValidator;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyViewConfig;

$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id' => 'oxpspasswordpolicy',
    'title' => [
        'de' => 'Passwortrichtlinie',
        'en' => 'Password Policy'
    ],
    'description' => [
        'de' => 'Prüfung der Kennwortstärke, Visualisierung, Abflaufregeln (modified by tabsl / fix guest registration)',
        'en' => 'Password validation, strength visualization and expiry rules (modified by tabsl / fix guest registration)',
    ],
    'thumbnail' => 'out/pictures/picture.png',
    'version' => '2.0.0',
    'author' => 'OXID Professional Services',
    'url' => 'http://www.oxid-sales.com',
    'email' => 'info@oxid-esales.com',
    'extend' => [
        ViewConfig::class => PasswordPolicyViewConfig::class,
        InputValidator::class => PasswordPolicyValidator::class
        ],
    'controllers' => [],
    'templates' => [
    ],
    'blocks' => [
        [
            'template' => 'form/fieldset/user_account.tpl',
            'block' => 'user_account_password',
            'file' => 'views/blocks/passwordpolicystrengthindicator.tpl',
        ],
        [
            'template' => 'form/forgotpwd_change_pwd.tpl',
            'block' => 'user_account_password',
            'file' => 'views/blocks/passwordpolicystrengthindicator.tpl',
        ],
        [
            'template' => 'form/user_password.tpl',
            'block' => 'user_account_password',
            'file' => 'views/blocks/passwordpolicystrengthindicator.tpl',
        ]
    ],
    'settings' => [
        ['group' => 'passwordpolicy', 'name' => 'oxpspasswordpolicyGoodPasswordLength', 'type' => 'num', 'value' => 12],
        ['group' => 'passwordpolicy', 'name' => 'oxpspasswordpolicyMinPasswordLength', 'type' => 'num', 'value' => 8],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicyUpperCase', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicyLowerCase', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicySpecial', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicyDigits', 'type' => 'bool', 'value' => true],
    ],
    'events' => [],
];
