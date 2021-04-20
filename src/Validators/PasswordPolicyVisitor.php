<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

class PasswordPolicyVisitor implements PasswordPolicyCheckInterface
{
    /**
     * @var PasswordPolicyCheckInterface[]
     */
    private $validators;
    /**
     * PasswordPolicyVisitor constructor.
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function validate(string $sUsername, string $sPassword)
    {
        foreach ($this->validators as $validator)
        {
            $sError = $validator->validate($sUsername, $sPassword);
            if (is_string($sError)) {
                return $sError;
            }
        }
        return true;
    }
}