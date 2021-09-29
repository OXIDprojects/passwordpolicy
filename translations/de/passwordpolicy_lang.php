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
    'passwordpolicy'                                             => 'Password Policy',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_TITLE'                   => 'Ihr Account wurde blockiert.',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_INFO'                    => 'Ihr Account wurde blockiert. Sie haben das Passwort zu oft hintereinander falsch eingegeben.',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_HINT'                    => 'Um dies in Zukunft zu vermeiden, benutzen Sie bitte die Funktion &bdquo;Passwort Zurücksetzen&rdquo;, wenn Sie das Passwort mehrmals falsch eingegeben haben.',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_ACTION'                  => 'Sie können Ihren Account wieder freischalten',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_RESETPASS'               => 'Passwort zurücksetzen',
    'OXPS_PASSWORDPOLICY_ACCOUNTBLOCKED_CONTACT'                 => 'Für weitere Hilfe zum zurücksetzen des Passwortes wenden Sie sich bitte an den Support.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_TITLE'                 => 'Stellen Sie sicher, dass ihr Passwort sicher ist.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_MEMO'                  => 'Starke Passwörter enthalten Buchstaben, Großbuchstaben, Zahlen und Sonderzeichen (z.B. Punkte, Bindestriche, Unterstriche). Je länger das Passwort, desto stärker ist es.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_NOPASSWORD'            => 'Kein Passwort eingetragen',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH0'             => 'Sehr schwach',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH1'             => 'Schwach',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH2'             => 'Besser',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH3'             => 'Durchschnittlich',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH4'             => 'Stark',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_STRENGTH5'             => 'Sehr Stark',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_MINLENGTH'           => 'Das Passwort hat nicht genügend Zeichen.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_UPPERCASE'           => 'Das Passwort enthält keine Großbuchstaben.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_LOWERCASE'           => 'Das Passwort enthält keine Kleinbuchstaben.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_DIGITS'              => 'Das Passwort enthält keine Ziffer.',
    'OXPS_PASSWORDPOLICY_PASSWORDVALIDATION_SPECIAL'             => 'Das Passwort muss mindestens eines der folgenden Zeichen enthalten: ! @ # $ % ^ & * ? _ ~ - ( ) ',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG'         => 'Das Passwort ist zu lang, bitte benutzen Sie ein kürzeres.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS'  => 'Das Passwort muss mindestens eine Zahl enthalten.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESUPPERCASE'   => 'Das Passwort muss mindestens einen Großbuchstaben enthalten.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESLOWERCASE'   => 'Das Passwort muss mindestens einen Kleinbuchstaben enthalten.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL' => 'Das Passwort muss mindestens ein Sonderzeichen enthalten.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_WRONGTYPE'       => 'Fehlerhafter Typ, bitte tragen Sie einen validen Wert ein. Bei weiteren Fragen wenden Sie sich an den Support.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN'  => 'Das Passwort befindet sich bereits in einer gehackten Datenbank und ist somit unsicher.',
    'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP' => 'Der eingebene Code für die Zwei-Faktor-Authentifizierung war falsch.',
    'OXPS_PASSWORDPOLICY_TOTP_ERROR_USEDOTP' => 'Der eingegebene Code wurde bereits zum Login verwendet.',
    'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGBACKUPCODE' => 'Der eingebene Backup Code war falsch.',
    'OXPS_PASSWORDPOLICY_RATELIMIT_EXCEEDED' => 'Sie haben sich zu oft versucht einzuloggen. Bitte versuchen Sie es später erneut.',
    'TWOFACTORAUTHREGISTER' => '2-Faktor-Authentifizierung Einrichtung',
    'TWOFACTORAUTHBACKUPCODE' => 'Backup-Code',
    'TWOFACTORAUTHRECOVERY' => '2-Faktor-Authentifizierung Reset',
    'TWOFACTORAUTHLOGIN' => '2-Faktor-Authentifizierung',
    'TWOFACTORAUTHCODE' => '2FA Code',
    'TWOFACTORAUTHCHECKBOX' => '2FA aktivieren',
    'TWOFACTORDEACTIVATE' => '2FA deaktivieren',
    'TWOFACTORCONTINUE' => 'Weiter',
    'TWOFACTORCONFIRM' => 'Verstanden',
    'TWOFACTORRESET' => 'Zurücksetzen',
    'MESSAGE_TWOFACTOR_HELP' => 'Die Zwei-Faktor-Authentifizierung bietet Ihrem Account eine zusätzliche Sicherheit. Durch aktivieren dieser Funktion, wird bei jedem Login nach einem zeitlich begrenzten einmaligen Passwort gefragt, welches Sie auf Ihrem Handy von einer App ablesen können.',
    'MESSAGE_TWOFACTOR_LOGIN' => 'Öffnen Sie jetzt Ihre Authentifizierungsapp und geben Sie den 6-stelligen Code ein.',
    'MESSAGE_TWOFACTOR_REGISTER' => 'Scannen Sie den abgebildeten QR Code mit ihrem Smartphone ein. Öffnen Sie dazu Ihre Kamera und richten Sie diese auf den Code.<br><b>Hinweis: Zum Verwenden der 2FA ist eine App erforderlich, welche Sie sich kostenlos herunterladen müssen.</b> ',
    'MESSAGE_TWOFACTOR_SUCCESS' => '2FA wurde erfolgreich eingerichtet.',
    'MESSAGE_TWOFACTOR_REGISTER_SUCCESS' => 'Sie haben sich erfolgreich registriert und richten nun die 2-Faktor-Authentifizierung ein.',
    'MESSAGE_TWOFACTOR_DEACTIVATED' => '2FA wurde deaktiviert.',
    'MESSAGE_TWOFACTOR_BACKUPCODE' => 'Für Sie wurde ein Wiederherstellungscode generiert. Falls Sie mal Ihr Gerät für die 2-Faktor-Authentifizierung verlieren sollten, ist dieser die <b>einzige</b> Möglichkeit um wieder Zugang zu Ihrem Account zu erlangen. <br> <b>Bewahren Sie den Wiederherstellungscode an einem sicheren Ort auf!</b>',
    'MESSAGE_TWOFACTOR_BACKUPCODE_SUCCESS' => 'Die 2FA wurde erfolgreich resettet. ',
    'MESSAGE_TWOFACTOR_RECOVERY' => 'Falls Sie Ihr Gerät für die 2FA verloren haben oder es sonstige Probleme damit gibt, geben Sie den einmaligen Wiederherstellungscode ein, der Ihnen beim Einrichten der 2FA angezeigt wurde. Anschließend wird 2FA bei Ihrem Account deaktiviert.',
    'MESSAGE_TWOFACTOR_LOST' => '<em>Sie brauchen Hilfe beim Login/haben Ihr Gerät für die 2FA verloren? Klicken Sie hier.</em>',
    'OXPS_CANNOTSTOREUSERSECRET' => 'Die 2-Faktor Einrichtung kann derzeit nicht durchgeführt werden, bitten versuchen Sie es später nochmal oder kontaktieren Sie uns.'
 );
