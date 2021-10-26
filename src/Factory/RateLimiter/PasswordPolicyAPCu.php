<?php


namespace OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter;


use RateLimit\ApcuRateLimiter;
use RateLimit\RateLimiter;

class PasswordPolicyAPCu implements PasswordPolicyRateLimiterInterface
{

    public function getLimiter(): RateLimiter
    {
        return new ApcuRateLimiter();
    }
}