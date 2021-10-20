<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyDigits implements PasswordPolicyValidationInterface
{

    private PasswordPolicyConfig $config;

    public function __construct(PasswordPolicyConfig $config)
    {
        $this->config = $config;
    }

    public function validate(string $sUsername, string $sPassword)
    {
        if ($this->config->getPasswordNeedDigits() && !preg_match('(\d+)', $sPassword)) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS';
        }
        return true;
    }
}
