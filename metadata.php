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

use OxidEsales\Eshop\Application\Component\UserComponent;
use OxidEsales\Eshop\Application\Controller\AccountPasswordController;
use OxidEsales\Eshop\Core\InputValidator;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Application\Controller\Admin\ModuleConfiguration;
use OxidProfessionalServices\PasswordPolicy\Component\PasswordPolicyUserComponent;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyAccountTOTP;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyTwoFactorConfirmation;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyTwoFactorBackupCode;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyTwoFactorRecovery;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyTwoFactorRegister;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyTwoFactorLogin;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyValidator;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyViewConfig;
use OxidProfessionalServices\PasswordPolicy\Controller\PasswordPolicyAccountPasswordController;
use OxidProfessionalServices\PasswordPolicy\Model\PasswordPolicyUser;
use OxidProfessionalServices\PasswordPolicy\Controller\Admin\PasswordPolicyModuleConfiguration;

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
        'de' => 'Prüfung der Kennwortstärke, Visualisierung, Abflaufregeln',
        'en' => 'Password validation, strength visualization and expiry rules',
    ],
    'thumbnail' => 'out/pictures/picture.png',
    'version' => '2.0.0',
    'author' => 'OXID Professional Services',
    'url' => 'http://www.oxid-sales.com',
    'email' => 'info@oxid-esales.com',
    'extend' => [
        ViewConfig::class => PasswordPolicyViewConfig::class,
        InputValidator::class => PasswordPolicyValidator::class,
        AccountPasswordController::class => PasswordPolicyAccountPasswordController::class,
        User::class => PasswordPolicyUser::class,
        ModuleConfiguration::class => PasswordPolicyModuleConfiguration::class,
        UserComponent::class => PasswordPolicyUserComponent::class
        ],
    'controllers' => [
        'twofactorregister' => PasswordPolicyTwoFactorRegister::class,
        'twofactorlogin' => PasswordPolicyTwoFactorLogin::class,
        'twofactoraccount' => PasswordPolicyAccountTOTP::class,
        'twofactorconfirmation' => PasswordPolicyTwoFactorConfirmation::class,
        'twofactorbackup' => PasswordPolicyTwoFactorBackupCode::class,
        'twofactorrecovery' => PasswordPolicyTwoFactorRecovery::class
    ],
    'templates' => [
        'twofactorregister.tpl'   => 'oxps/passwordpolicy/views/tpl/twofactorregister.tpl',
        'twofactorlogin.tpl' => 'oxps/passwordpolicy/views/tpl/twofactorlogin.tpl',
        'twofactoraccount.tpl' => 'oxps/passwordpolicy/views/tpl/twofactoraccount.tpl',
        'twofactorconfirmation.tpl' => 'oxps/passwordpolicy/views/tpl/twofactorconfirmation.tpl',
        'twofactorbackupcode.tpl' => 'oxps/passwordpolicy/views/tpl/twofactorbackupcode.tpl',
        'twofactorrecovery.tpl' => 'oxps/passwordpolicy/views/tpl/twofactorrecovery.tpl',

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
        ],
        [
            'template' => 'form/fieldset/user_account.tpl',
            'block' => 'user_account_newsletter',
            'file' => 'views/blocks/user_account.tpl',
        ],
        [
            'template' => 'page/account/inc/account_menu.tpl',
            'block' => 'account_menu',
            'file' => 'views/blocks/account_menu.tpl',
        ]

    ],
    'settings' => [
        ['group' => 'passwordpolicy', 'name' => 'oxpspasswordpolicyGoodPasswordLength', 'type' => 'num', 'value' => 12],
        ['group' => 'passwordpolicy', 'name' => 'oxpspasswordpolicyMinPasswordLength', 'type' => 'num', 'value' => 8],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicyUpperCase', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicyLowerCase', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicySpecial', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_requirements', 'name' => 'oxpspasswordpolicyDigits', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_api', 'name' => 'oxpspasswordpolicyAPI', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_api', 'name' => 'oxpspasswordpolicyHaveIBeenPwned', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_api', 'name' => 'oxpspasswordpolicyEnzoic', 'type' => 'bool', 'value' => false],
        ['group' => 'passwordpolicy_api', 'name' => 'oxpspasswordpolicyEnzoicAPIKey', 'type' => 'str', 'value'=>''],
        ['group' => 'passwordpolicy_api', 'name' => 'oxpspasswordpolicyEnzoicSecretKey', 'type' => 'str', 'value'=>''],
        ['group' => 'passwordpolicy_ratelimiting', 'name' => 'oxpspasswordpolicyRateLimiting', 'type' => 'bool', 'value' => true],
        ['group' => 'passwordpolicy_ratelimiting', 'name' => 'oxpspasswordpolicyRateLimitingDrivers', 'type' => 'select', 'value' => 'APCu', 'constraints' => 'Memcached|APCu'],
        ['group' => 'passwordpolicy_ratelimiting', 'name' => 'oxpspasswordpolicyRateLimitingLimit', 'type' => 'num', 'value' => 60],
        ['group' => 'passwordpolicy_memcached', 'name' => 'oxpspasswordpolicyMemcachedHost', 'type' => 'str', 'value' => 'memcached'],
        ['group' => 'passwordpolicy_memcached', 'name' => 'oxpspasswordpolicyMemcachedPort', 'type' => 'num', 'value' => 11211],
        ['group' => 'passwordpolicy_twofactor', 'name' => 'oxpspasswordpolicyTOTP', 'type' => 'bool', 'value' => false],
    ],
    'events'       => array(
        'onActivate'   => 'OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyEvents::onActivate',
    ),
];
