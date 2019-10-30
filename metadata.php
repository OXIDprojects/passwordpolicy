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

/**
 * Metadata version
 */
$sMetadataVersion = '1.1';

/**
 * Module information
 */
$aModule = array(
    "id"          => "oxpspasswordpolicy",
    "title"       => array(
        'de' => 'Kennwortrichtlinie',
        'en' => 'Password Policy'
    ),
    "description" => array(
        'de'    =>  'Prüfung der Kennwortstärke, Visualisierung, Abflaufregeln',
        'en'    =>  'Password validation, strength visualization and expiry rules',
    ),
    "thumbnail"   => "out/pictures/picture.png",
    "version"     => "0.8.4",
    "author"      => "OXID Professional Services",
    "url"         => "http://www.oxid-sales.com",
    "email"       => "info@oxid-esales.com",
    "extend"      => array(
        "oxcmp_user"       => "oxps/passwordpolicy/components/oxpspasswordpolicyuser",
        "account_password" => "oxps/passwordpolicy/controllers/oxpspasswordpolicyaccountpassword",
        "forgotpwd"        => "oxps/passwordpolicy/controllers/oxpspasswordpolicyforgotpwd",
        "register"         => "oxps/passwordpolicy/controllers/oxpspasswordpolicyregister",
        "user"             => "oxps/passwordpolicy/controllers/oxpspasswordpolicycheckoutuser",
    ),
    "files"       => array(
        "oxpspasswordpolicymodule"  => "oxps/passwordpolicy/components/oxpspasswordpolicymodule.php",
        "oxpspasswordpolicy"        => "oxps/passwordpolicy/controllers/oxpspasswordpolicy.php",
        "oxpspasswordpolicyattempt" => "oxps/passwordpolicy/models/oxpspasswordpolicyattempt.php",
        'admin_oxpspasswordpolicy'  => 'oxps/passwordpolicy/controllers/admin/admin_oxpspasswordpolicy.php',
    ),
    "templates"   => array(
        "passwordpolicyaccountblocked.tpl" => "oxps/passwordpolicy/views/pages/passwordpolicyaccountblocked.tpl",
        "admin_oxpspasswordpolicy.tpl"     => "oxps/passwordpolicy/views/admin/admin_oxpspasswordpolicy.tpl",
    ),
    'blocks'      => array(
        array(
            'template' => 'form/fieldset/user_account.tpl',
            'block'    => 'user_account_password',
            'file'     => 'views/blocks/passwordpolicystrengthindicator.tpl',
        ),
        array(
            'template' => 'form/forgotpwd_change_pwd.tpl',
            'block'    => 'user_account_password',
            'file'     => 'views/blocks/passwordpolicystrengthindicator.tpl',
        ),
        array(
            'template' => 'form/user_password.tpl',
            'block'    => 'user_account_password',
            'file'     => 'views/blocks/passwordpolicystrengthindicator.tpl',
        )
    ),
    'settings'    => array(
        array( 'name' => 'iMaxAttemptsAllowed', 'type'=>'int', value => 3),
        array( 'name' => 'iTrackingPeriod', 'type'=>'int', value => 60),
        array( 'name' => 'blAllowUnblock', 'type'=>'bool', value => false),
        array( 'name' => 'iMinPasswordLength', 'type'=>'int', value => 6),
        array( 'name' => 'iGoodPasswordLength', 'type'=>'int', value => 12),
        array( 'name' => 'iMaxPasswordLength', 'type'=>'int', value => 100),
        array( 'name' => 'aPasswordRequirements', 'type'=>'aarr', value => array(
            'digits'=>true,
            'capital'=>true,
            'special'=>true,
            'lower'=>true,
        ))
    ),
    'events'      => array(
        'onActivate'   => 'OxpsPasswordPolicyModule::onActivate',
        'onDeactivate' => 'OxpsPasswordPolicyModule::onDeactivate',
    ),
);
