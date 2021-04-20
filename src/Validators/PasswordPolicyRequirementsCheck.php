<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyRequirementsCheck implements PasswordPolicyCheckInterface
{
    public function getModuleSettings(): PasswordPolicyConfig
    {
        return Registry::get(PasswordPolicyConfig::class);
    }

    public function validate(string $sUsername, string $sPassword)
    {
        $iPasswordLength = mb_strlen($sPassword, 'UTF-8');

        $settings = $this->getModuleSettings();

        if ($iPasswordLength < $settings->getMinPasswordLength()) {
            return $sError = 'ERROR_MESSAGE_PASSWORD_TOO_SHORT';
        }

        if ($iPasswordLength > $settings->getMaxPasswordLength()) {
            return $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG';
        }

        if ($settings->getPasswordNeedDigits() and !preg_match('(\d+)', $sPassword)) {
            return $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS';
        }

        if ($settings->getPasswordNeedUpperCase() and !preg_match('(\p{Lu}+)', $sPassword)) {
            return $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESUPPERCASE';
        }

        if ($settings->getPasswordNeedLowerCase() and !preg_match('(\p{Ll}+)', $sPassword)) {
            return $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESLOWERCASE';
        }

        if (
            $settings->getPasswordNeedSpecialCharacter() and
            !preg_match('([\.,_@\~\(\)\!\#\$%\^\&\*\+=\-\\\/|:;`]+)', $sPassword)
        ) {
            return $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL';
        }
        return true;
    }
}