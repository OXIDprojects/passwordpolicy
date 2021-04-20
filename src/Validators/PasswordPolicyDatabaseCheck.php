<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


use OxidProfessionalServices\PasswordPolicy\Api\PasswordCheck;

class PasswordPolicyDatabaseCheck implements PasswordPolicyCheckInterface
{

    public function validate(string $sUsername, string $sPassword)
    {
        $pc = new PasswordCheck();
        if ($pc->isPasswordKnown($sPassword)) {
           return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN';
        }
        return true;
    }

}