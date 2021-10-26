<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

class PasswordPolicyValidatorsCollector implements PasswordPolicyValidationInterface
{
    /**
     * @var PasswordPolicyValidationInterface[]
     */
    private array $validators;
    /**
     * PasswordPolicyValidatorsCollector constructor.
     */
    public function __construct(array $validators)
    {
        $this->validators = $validators;
    }

    public function validate(string $sUsername, string $sPassword)
    {
        foreach ($this->validators as $validator) {
            $sError = $validator->validate($sUsername, $sPassword);
            if (is_string($sError)) {
                return $sError;
            }
        }
        return true;
    }
}
