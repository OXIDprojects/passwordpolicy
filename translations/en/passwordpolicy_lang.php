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

$sLangName = "Deutsch";

$aLang = array(
    'charset'                                                    => 'UTF-8',
    'passwordpolicy'                                             => 'Password policy',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_TITLE'                   => 'Your account has been blocked.',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_INFO'                    => 'Your account has been blocked. You have entered your password incorrectly too many times in a row.',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_HINT'                    => 'In order to avoid this in the future, please reset your password after entering it incorrectly a few times.',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_ACTION'                  => 'You can reactivate your account',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_RESETPASS'               => 'Reset password',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_CONTACT'                 => 'Please contact the support if you need assistance with resetting your password.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_TITLE'                 => 'Make sure you choose a secure password.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_MEMO'                  => 'Secure passwords contain letters, capital letters, numbers and special characters (e.g. periods, hyphens, underscores). The longer the password, the better it is.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_NOPASSWORD'            => 'No password entered',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH0'             => 'Very weak',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH1'             => 'Weak',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH2'             => 'Better',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH3'             => 'Average',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH4'             => 'Strong',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH5'             => 'Very strong',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_MINLENGTH'           => 'The password is too short.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_UPPERCASE'           => 'Please enter at least one capital letter.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_LOWERCASE'           => 'Please enter at least one lower case letter.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_DIGITS'              => 'Please enter at least one number.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_SPECIAL'             => 'The password must include at least one of the following characters: ! @ # $ % ^ &amp; * ? _ ~ - ( ) ',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG'         => 'The password is too long. Please enter a shorter one.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS'  => 'The password must include at least one figure.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESUPPERCASE'   => 'The password must include at least one capital letter.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESLOWERCASE'   => 'The password must include at least one lower case letter.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL' => 'The password must include at least one special character and one figure.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_WRONGTYPE'       => 'Incorrect type, please enter a valid value. If you have any further questions, please contact the support.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN'  => 'The password already exists in a hacked database. Please choose a safer one.',
    'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP' => 'Your entered OTP was wrong.',
    'OXPS_PASSWORDPOLICY_TOTP_ERROR_USEDOTP' => 'Your entered OTP was already used for a previous login.',
    'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGBACKUPCODE' => 'Your entered backup code was wrong.',
    'OXPS_PASSWORDPOLICY_RATELIMIT_EXCEEDED' => 'You tried to login too many times. Please try again later.',
    'TWOFACTORAUTHREGISTER' => '2-Factor-Authentification Registration',
    'TWOFACTORAUTHBACKUPCODE' => 'Backup-Code',
    'TWOFACTORAUTHRECOVERY' => '2-Factor-Authentification Reset',
    'TWOFACTORAUTHLOGIN' => '2-Factor-Authentification',
    'TWOFACTORAUTHCODE' => '2FA Code',
    'TWOFACTORAUTHCHECKBOX' => 'Activate 2FA',
    'TWOFACTORDEACTIVATE' => 'Deacitvate 2FA',
    'TWOFACTORCONTINUE' => 'Continue',
    'TWOFACTORCONFIRM' => 'Accept',
    'TWOFACTORRESET' => 'Reset',
    'MESSAGE_TWOFACTOR_HELP' => 'Two-factor authentication adds an extra layer of security to your account. By enabling this feature, each time you log in, you will be asked for a time-limited one-time password, which you can enter by using your OTP App on your phone.',
    'MESSAGE_TWOFACTOR_LOGIN' => 'Now open your authentication app and enter the 6-digit code.',
    'MESSAGE_TWOFACTOR_REGISTER' => 'Now open your camera and scan the shown QR code with your smartphone. <br><b>Note: To use the 2FA, an app is required, which you can download for free.</b>. ',
    'MESSAGE_TWOFACTOR_SUCCESS' => '2FA has been successfully set up.',
    'MESSAGE_TWOFACTOR_REGISTER_SUCCESS' => 'You have successfully registered and are now setting up the 2-factor authentication.',
    'MESSAGE_TWOFACTOR_DEACTIVATED' => '2FA was deactivated.',
    'MESSAGE_TWOFACTOR_BACKUPCODE' => 'A recovery code has been generated for you. If you ever lose your 2-factor authentication device, this is the <b>only</b> way to regain access to your account. <br> <b>Keep the recovery code in a safe place!</b>',
    'MESSAGE_TWOFACTOR_BACKUPCODE_SUCCESS' => 'The 2FA has been successfully reset',
    'MESSAGE_TWOFACTOR_RECOVERY' => 'If you have lost your 2FA device or there are other problems with it, enter the unique recovery code that was shown to you when you set up the 2FA. After that, 2FA will be disabled on your account.',
    'MESSAGE_TWOFACTOR_LOST' => '<em>Need help logging in/have lost your device for 2FA? Click here</em>'
);
