<?php

declare(strict_types=1);

namespace OxidProfessionalServices\PasswordPolicy\Api;
use Enzoic\Enzoic;
use Enzoic\PasswordType;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordCheck
{


    public function isPasswordKnown(string $password): bool
    {
        $config = new PasswordPolicyConfig();
        if(!$config->getAPINeeded())
        {
            return false;
        }
        $apiCon = new Enzoic($config->getAPIKey(), $config->getSecretKey());
        $result = $apiCon->checkPassword($password);
        return $result !== null;
    }

}