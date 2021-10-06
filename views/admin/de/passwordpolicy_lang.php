<?php

/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @category  translations
 * @package   passwordpolicy
 * @author    OXID Professional services
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2013
 */

$sLangName = "Deutsch";

$aLang = array(
    'charset' => 'UTF-8',
    'oxpspasswordpolicy' => 'Password Policy',
    'SHOP_MODULE_oxpspasswordpolicyMinPasswordLength' => "Minimale Länge",
    'HELP_SHOP_MODULE_oxpspasswordpolicyMinPasswordLength' => 'Min. erlaubte Passwortlänge. Sollte länger als 8 sein.',
    'SHOP_MODULE_GROUP_passwordpolicy' => 'Einstellungen zur Passwortlänge',
    'SHOP_MODULE_oxpspasswordpolicyGoodPasswordLength' => 'Gute Länge',
    'HELP_SHOP_MODULE_oxpspasswordpolicyGoodPasswordLength' => 'Starke Passwortlänge. Sollte länger als 12 sein.',
    'SHOP_MODULE_GROUP_passwordpolicy_requirements' => 'Erforderliche Zeichen',
    'SHOP_MODULE_oxpspasswordpolicyDigits' => 'Ziffern (0...9)',
    'SHOP_MODULE_oxpspasswordpolicyUpperCase' => 'Großbuchstaben (A...Z)',
    'SHOP_MODULE_oxpspasswordpolicyLowerCase'   => 'Kleinbuchstaben (a...z)',
    'SHOP_MODULE_oxpspasswordpolicySpecial' => 'Sonderzeichen (!,@#$%^&*?_~()-)',
    'SHOP_MODULE_GROUP_passwordpolicy_api' => 'Verbrannte Passwörter',
    'SHOP_MODULE_oxpspasswordpolicyAPI' => 'Verbrannte Passwörter überprüfen',
    'SHOP_MODULE_oxpspasswordpolicyHaveIBeenPwned' => 'HaveIBeenPwned',
    'SHOP_MODULE_oxpspasswordpolicyEnzoic' => 'Enzoic',
    'SHOP_MODULE_oxpspasswordpolicyEnzoicAPIKey' => 'Enzoic API Schlüssel',
    'SHOP_MODULE_oxpspasswordpolicyEnzoicSecretKey' => 'Enzoic Geheimschlüssel',
    'SHOP_MODULE_GROUP_passwordpolicy_admin' => "Admin Einstellungen",
    'SHOP_MODULE_oxpspasswordpolicyadmin' => "Sicherheitsfeatures für Admins aktivieren",
    'OXPS_PASSWORDPOLICY_ENZOICERROR401' => 'Ihr Enzoic API Key oder Secret Key ist nicht gültig. Sie sind nicht autorisiert.',
    'OXPS_PASSWORDPOLICY_ENZOICERRORError0' => 'Es gibt ein Problem beim Verbinden mit der Enzoic API. Bitte versuchen Sie es erneut.',
    'OXPS_PASSWORDPOLICY_ENZOICERROR500' => 'Ein unerwarteter Fehler ist aufgetreten. Btte probieren Sie es später erneut.',
    'OXPS_PASSWORDPOLICY_INVALIDADMINUSERS' => "Um diese Funktion nutzen zu können, müssen alle Administratoren eine gültige Mail besitzen. \n Folgende Administratoren haben eine ungültige Mail:",
    'OXPS_PASSWORDPOLICY_RATELIMIT_EXCEEDED' => 'Sie haben sich zu oft versucht einzuloggen. Bitte versuchen Sie es später erneut.',
    'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN'  => 'Das Passwort befindet sich bereits in einer gehackten Datenbank und ist somit unsicher.',
    'SHOP_MODULE_GROUP_passwordpolicy_ratelimiting' => 'Rate Limiting Einstellungen',
    'SHOP_MODULE_oxpspasswordpolicyRateLimiting' => 'Aktiv',
    'SHOP_MODULE_oxpspasswordpolicyRateLimitingDrivers' => 'Treiber',
    'SHOP_MODULE_oxpspasswordpolicyRateLimitingDrivers_Redis' => 'Redis',
    'SHOP_MODULE_oxpspasswordpolicyRateLimitingDrivers_Predis' => 'Predis',
    'SHOP_MODULE_oxpspasswordpolicyRateLimitingDrivers_Memcached' => 'Memcached',
    'SHOP_MODULE_oxpspasswordpolicyRateLimitingDrivers_APCu' => 'APCu',
    'SHOP_MODULE_oxpspasswordpolicyRateLimitingLimit' => 'Einlogversuche pro Minute',
    'SHOP_MODULE_oxpspasswordpolicyMemcachedHost' => 'Memcached Host',
    'SHOP_MODULE_oxpspasswordpolicyMemcachedPort' => 'Memcached Port',
    'SHOP_MODULE_GROUP_passwordpolicy_twofactor' => '2FA Authentifizierung',
    'SHOP_MODULE_oxpspasswordpolicyTOTP' => '2FA aktivieren',
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
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ERROR_WRONGOTP' => 'Der eingebene Code für die Zwei-Faktor-Authentifizierung war falsch.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ERROR_USEDOTP' => 'Der eingegebene Code wurde bereits zum Login verwendet.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ERROR_WRONGBACKUPCODE' => 'Der eingebene Backup Code war falsch.',
    'OXPS_PASSWORDPOLICY_RATELIMIT_TWOFACTOR_EXCEEDED' => 'Sie haben zu oft den falschen Code für die Zwei-Faktor-Authentifizierung eingegeben. Bitte versuchen Sie es später erneut.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_REGISTER' => '2-Faktor-Authentifizierung Einrichtung',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_BACKUPCODE' => 'Backup-Code',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_RECOVERY' => '2-Faktor-Authentifizierung Reset',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN' => '2-Faktor-Authentifizierung',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ACTIVATE' => '2FA aktivieren',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_DEACTIVATE' => '2FA deaktivieren',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_CONTINUE' => 'Weiter',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_CONFIRM' => 'Verstanden',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_RESET' => 'Zurücksetzen',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_INFO' => 'Die Zwei-Faktor-Authentifizierung bietet Ihrem Account eine zusätzliche Sicherheit. Durch aktivieren dieser Funktion, wird bei jedem Login nach einem zeitlich begrenzten einmaligen Passwort gefragt, welches Sie auf Ihrem Handy von einer App ablesen können.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_LOGIN' => 'Öffnen Sie jetzt Ihre Authentifizierungsapp und geben Sie den 6-stelligen Code ein.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_REGISTER' => 'Scannen Sie den abgebildeten QR Code mit ihrem Smartphone ein. Öffnen Sie dazu Ihre Kamera und richten Sie diese auf den Code.<br><b>Hinweis: Zum Verwenden der 2FA ist eine App erforderlich, welche Sie sich kostenlos herunterladen müssen.</b> ',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_RECOVERY' => 'Falls Sie Ihr Gerät für die 2FA verloren haben oder es sonstige Probleme damit gibt, geben Sie den einmaligen Wiederherstellungscode ein, der Ihnen beim Einrichten der 2FA angezeigt wurde. Anschließend wird 2FA bei Ihrem Account deaktiviert.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_LOST' => '<em>Sie brauchen Hilfe beim Login/haben Ihr Gerät für die 2FA verloren? Klicken Sie hier.</em>',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_HELP_BACKUPCODE' => 'Für Sie wurde ein Wiederherstellungscode generiert. Falls Sie mal Ihr Gerät für die 2-Faktor-Authentifizierung verlieren sollten, ist dieser die <b>einzige</b> Möglichkeit um wieder Zugang zu Ihrem Account zu erlangen. <br> <b>Bewahren Sie den Wiederherstellungscode an einem sicheren Ort auf!</b>',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ACTIVATED' => '2FA wurde erfolgreich eingerichtet.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_DEACTIVATED' => '2FA wurde deaktiviert.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_REGISTER_SUCCESS' => 'Sie haben sich erfolgreich registriert und richten nun die 2-Faktor-Authentifizierung ein.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_REGISTER_ERROR' => 'Die 2-Faktor Einrichtung kann derzeit nicht durchgeführt werden, bitten versuchen Sie es später nochmal oder kontaktieren Sie uns.',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_RESET_SUCCESS' => 'Die 2FA wurde erfolgreich resettet. ',
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_YES' => "Aktivieren",
    'OXPS_PASSWORDPOLICY_TWOFACTORAUTH_NO' => 'Deaktivieren'

);
