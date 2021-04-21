<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyDigits implements PasswordPolicyValidationInterface
{
    public function validate(string $sUsername, string $sPassword)
    {
        $settings = new PasswordPolicyConfig();
        if ($settings->getPasswordNeedDigits() and !preg_match('(\d+)', $sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS';
        }
        return true;
    }
}