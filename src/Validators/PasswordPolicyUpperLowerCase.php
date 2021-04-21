<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyUpperLowerCase implements PasswordPolicyValidationInterface
{
    public function validate(string $sUsername, string $sPassword)
    {
        $settings = new PasswordPolicyConfig();
        if ($settings->getPasswordNeedUpperCase() and !preg_match('(\p{Lu}+)', $sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESUPPERCASE';
        }

        if ($settings->getPasswordNeedLowerCase() and !preg_match('(\p{Ll}+)', $sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESLOWERCASE';
        }
        return true;
    }
}