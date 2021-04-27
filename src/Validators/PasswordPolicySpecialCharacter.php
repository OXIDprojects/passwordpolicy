<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicySpecialCharacter implements PasswordPolicyValidationInterface
{
    public function validate(string $sUsername, string $sPassword)
    {
        $settings = new PasswordPolicyConfig();
        if (
            $settings->getPasswordNeedSpecialCharacter() and
            !preg_match('([\.,_@\~\(\)\!\#\$%\^\&\*\+=\-\\\/|:;`]+)', $sPassword)
        ) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL';
        }
        return true;
    }
}
