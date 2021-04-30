<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Api\PasswordCheck;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyDataBreach implements PasswordPolicyValidationInterface
{

    private PasswordPolicyConfig $config;
    private PasswordCheck $passwordCheck;

    public function __construct(PasswordPolicyConfig $config, PasswordCheck $passwordCheck)
    {
        $this->config = $config;
        $this->passwordCheck = $passwordCheck;
    }

    public function validate(string $sUsername, string $sPassword)
    {
        if ($this->config->getAPINeeded() && ($this->passwordCheck->isPasswordKnown($sPassword) || $this->passwordCheck->isCredentialsKnown($sUsername, $sPassword))) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN';
        }
        return true;
    }
}
