<?php


namespace OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter;


use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use RateLimit\MemcachedRateLimiter;

class PasswordPolicyMemcached implements PasswordPolicyRateLimiterInterface
{
    private string $host;
    private int $port;
    /**
     * PasswordPolicyMemcached constructor.
     */
    public function __construct()
    {
        $config = new PasswordPolicyConfig();
        $this->host = $config->getMemcachedHost();
        $this->port = $config->getMemcachedPort();
    }

    public function getLimiter(): MemcachedRateLimiter
    {
        $memcached = new \Memcached();
        $memcached->addServer($this->host,$this->port);
        $memcached->setOption(\Memcached::OPT_BINARY_PROTOCOL, TRUE);
        return new MemcachedRateLimiter($memcached);
    }

}