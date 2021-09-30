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
    'SHOP_MODULE_oxpspasswordpolicyTOTP' => '2FA aktivieren'

);
