<?php


namespace OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter;


use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use RateLimit\MemcachedRateLimiter;
use RateLimit\RateLimiter;

class PasswordPolicyMemcached implements PasswordPolicyRateLimiterInterface
{
    private PasswordPolicyConfig $config;
    private string $host;
    private int $port;
    /**
     * PasswordPolicyMemcached constructor.
     */
    public function __construct(PasswordPolicyConfig $config)
    {
        $this->config = $config;
        $this->host = $config->getMemcachedHost();
        $this->port = $config->getMemcachedPort();
    }

    public function getLimiter(): RateLimiter
    {
        $memcached = new \Memcached();
        $memcached->addServer($this->host,$this->port);
        $memcached->setOption(\Memcached::OPT_BINARY_PROTOCOL, TRUE);
        return new MemcachedRateLimiter($memcached);
    }

}