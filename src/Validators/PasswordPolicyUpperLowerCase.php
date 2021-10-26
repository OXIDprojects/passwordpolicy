<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyUpperLowerCase implements PasswordPolicyValidationInterface
{
    private PasswordPolicyConfig $config;

    public function __construct(PasswordPolicyConfig $config)
    {
        $this->config = $config;
    }

    public function validate(string $sUsername, string $sPassword)
    {
        $settings = $this->config;
        if ($settings->getPasswordNeedUpperCase() && !preg_match('(\p{Lu}+)', $sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESUPPERCASE';
        }

        if ($settings->getPasswordNeedLowerCase() && !preg_match('(\p{Ll}+)', $sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESLOWERCASE';
        }
        return true;
    }
}
