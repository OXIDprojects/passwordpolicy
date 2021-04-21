<?php

declare(strict_types=1);

namespace OxidProfessionalServices\PasswordPolicy\Api;
use Enzoic\Enzoic;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordCheck
{


    public function isPasswordKnown(string $password): bool
    {
        $config = new PasswordPolicyConfig();
        $apiCon = new Enzoic($config->getAPIKey(), $config->getSecretKey());
        $result = $apiCon->checkPassword($password);
        return $result !== null;
    }

}