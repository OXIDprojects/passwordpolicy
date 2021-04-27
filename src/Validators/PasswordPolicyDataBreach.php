<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Api\PasswordCheck;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyDataBreach implements PasswordPolicyValidationInterface
{
    public function validate(string $sUsername, string $sPassword)
    {
        $settings = new PasswordPolicyConfig();
        $passwordCheck = new PasswordCheck();
        if ($settings->getAPINeeded() && ($passwordCheck->isPasswordKnown($sPassword) || $passwordCheck->isCredentialsKnown($sUsername, $sPassword))) {
            return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN';
        }
        return true;
    }
}
