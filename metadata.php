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
$sMetadataVersion = '2.1';

/**
 * Module information
 */
$aModule = [
    'id' => 'oxpspasswordpolicy',
    'title' => [
        'de' => 'Kennwortrichtlinie',
        'en' => 'Password Policy'
    ],
    'description' => [
        'de' => 'Prüfung der Kennwortstärke, Visualisierung, Abflaufregeln',
        'en' => 'Password validation, strength visualization and expiry rules',
    ],
    'thumbnail' => 'out/pictures/picture.png',
    'version' => '1.0.0',
    'author' => 'OXID Professional Services',
    'url' => 'http://www.oxid-sales.com',
    'email' => 'info@oxid-esales.com',
    'extend' => [
        \OxidEsales\Eshop\Application\Component\UserComponent::class
            => \OxidProfessionalServices\PasswordPolicy\Component\UserComponent::class,
        \OxidEsales\Eshop\Application\Controller\AccountPasswordController::class
            => \OxidProfessionalServices\PasswordPolicy\Controller\AccountPasswordController::class,
        \OxidEsales\Eshop\Application\Controller\ForgotPasswordController::class
            => \OxidProfessionalServices\PasswordPolicy\Controller\ForgotPasswordController::class,
        \OxidEsales\Eshop\Application\Controller\RegisterController::class
            => \OxidProfessionalServices\PasswordPolicy\Controller\RegisterController::class,
        \OxidEsales\Eshop\Application\Controller\UserController::class
            => \OxidProfessionalServices\PasswordPolicy\Controller\UserController::class,
        ],
    'controllers' => [
        'oxpspasswordpolicy' => \OxidProfessionalServices\PasswordPolicy\Controller\OxpsPasswordPolicy::class,
        'admin_oxpspasswordpolicy' => \OxidProfessionalServices\PasswordPolicy\Controller\Admin\OxpsPasswordPolicyAdmin::class,
    ],
    'templates' => [
        'passwordpolicyaccountblocked.tpl' => 'oxps/passwordpolicy/views/pages/passwordpolicyaccountblocked.tpl',
        'admin_oxpspasswordpolicy.tpl' => 'oxps/passwordpolicy/views/admin/admin_oxpspasswordpolicy.tpl',
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
        ['name' => 'iMaxAttemptsAllowed', 'type' => 'int', 'value' => 3],
        ['name' => 'iTrackingPeriod', 'type' => 'int', 'value' => 60],
        ['name' => 'blAllowUnblock', 'type' => 'bool', 'value' => false],
        ['name' => 'iMinPasswordLength', 'type' => 'int', 'value' => 6],
        ['name' => 'iGoodPasswordLength', 'type' => 'int', 'value' => 12],
        ['name' => 'iMaxPasswordLength', 'type' => 'int', 'value' => 100],
        ['name' => 'aPasswordRequirements', 'type' => 'aarr', 'value' => [
            'digits' => true,
            'capital' => true,
            'special' => true,
            'lower' => true,
        ]]
    ],
    'events' => [
        'onActivate' => 'OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyModule::onActivate',
        'onDeactivate' => 'OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyModule::onDeactivate',
    ],
];
