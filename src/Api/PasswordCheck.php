<?php

declare(strict_types=1);

namespace OxidProfessionalServices\PasswordPolicy\Api;

use Enzoic\Enzoic;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

/**
 * Class PasswordCheck
 * @package OxidProfessionalServices\PasswordPolicy\Api
 */
class PasswordCheck
{

    private $config;
    private $apiCon;

    /**
     * PasswordCheck constructor.
     */
    public function __construct()
    {
        $this->config = new PasswordPolicyConfig();
        $this->apiCon = new Enzoic($this->config->getAPIKey(), $this->config->getSecretKey());
    }

    /**
     * @param string $password
     * @return bool
     */
    public function isPasswordKnown(string $password): bool
    {
        $result = $this->apiCon->checkPassword($password);
        return $result !== null;
    }

    /**
     * @param string $username
     * @param string $password
     * @return bool
     */
    public function isCredentialsKnown(string $username, string $password): bool
    {
        $result = $this->apiCon->checkCredentials($username, $password);
        return $result;
    }

}