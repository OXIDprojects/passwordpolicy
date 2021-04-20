<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


/**
 * Interface PasswordPolicyCheckInterface
 * @package OxidProfessionalServices\PasswordPolicy\Validators
 */
interface PasswordPolicyCheckInterface
{
    /**
     * @param string $sUsername
     * @param string $sPassword
     * return true|string
     */
    public function validate(string $sUsername, string $sPassword);
}