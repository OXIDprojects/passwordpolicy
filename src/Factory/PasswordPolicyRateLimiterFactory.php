<?php

namespace OxidProfessionalServices\PasswordPolicy\Factory;

use OxidProfessionalServices\PasswordPolicy\Exception\LimiterNotFound;
use OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter\PasswordPolicyMemcached;
use OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter\PasswordPolicyAPCu;
use OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter\PasswordPolicyRateLimiterInterface;

class PasswordPolicyRateLimiterFactory
{
    private array $versionMap = [
        "Memcached" => PasswordPolicyMemcached::class,
        "APCu" => PasswordPolicyAPCu::class
    ];

    /**
     * @param string $version
     * @return PasswordPolicyRateLimiterInterface
     * @throws LimiterNotFound
     */
    public function getRateLimiter(string $version): PasswordPolicyRateLimiterInterface
    {
        if (!isset($this->versionMap[$version])) {
            throw new LimiterNotFound();
        }
        $driver = new $this->versionMap[$version]();
        return $driver;
    }
}