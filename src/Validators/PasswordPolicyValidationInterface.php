<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

/**
 * Interface PasswordPolicyValidationInterface
 * @package OxidProfessionalServices\PasswordPolicy\Validators
 */
interface PasswordPolicyValidationInterface
{
    /**
     * @param string $sUsername
     * @param string $sPassword
     * return true|string
     */
    public function validate(string $sUsername, string $sPassword);
}
