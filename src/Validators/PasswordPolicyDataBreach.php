<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;

use OxidProfessionalServices\PasswordPolicy\Api\PasswordCheck;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use Psr\Log\LoggerInterface;

class PasswordPolicyDataBreach implements PasswordPolicyValidationInterface
{

    private PasswordPolicyConfig $config;
    private PasswordCheck $passwordCheck;
    private LoggerInterface $logger;

    public function __construct(PasswordPolicyConfig $config, PasswordCheck $passwordCheck, LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->config = $config;
        $this->passwordCheck = $passwordCheck;
    }

    public function validate(string $sUsername, string $sPassword)
    {
        try {
            if ($this->config->getAPINeeded() && $this->passwordCheck->isPasswordKnown($sUsername, $sPassword)) {
                return 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN';
            }
        } catch (\RuntimeException $exception) {
            $errorClass = get_class($exception);
            $code = $exception->getCode();
            $this->logger->warning("Enzoic API Error: $errorClass Code: $code");
        }
        return true;
    }
}
