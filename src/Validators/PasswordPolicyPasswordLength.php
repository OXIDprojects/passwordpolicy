<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyPasswordLength implements PasswordPolicyValidationInterface
{
    public function validate(string $sUsername, string $sPassword)
    {
        $iPasswordLength = mb_strlen($sPassword, 'UTF-8');
        $settings = new PasswordPolicyConfig();
        if ($iPasswordLength < $settings->getMinPasswordLength()) {
            return 'ERROR_MESSAGE_PASSWORD_TOO_SHORT';
        }

        if ($iPasswordLength > $settings->getMaxPasswordLength()) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG';
        }
        return true;
    }
}