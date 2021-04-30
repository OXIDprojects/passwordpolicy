<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicySpecialCharacter implements PasswordPolicyValidationInterface
{
    private PasswordPolicyConfig $config;

    public function __construct(PasswordPolicyConfig $config)
    {
        $this->config = $config;
    }

    public function validate(string $sUsername, string $sPassword)
    {

        if (
            $this->config->getPasswordNeedSpecialCharacter() and
            !preg_match('([\.,_@\~\(\)\!\#\$%\^\&\*\+=\-\\\/|:;`]+)', $sPassword)
        ) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL';
        }
        return true;
    }
}
