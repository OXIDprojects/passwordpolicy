<?php


namespace OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter;


use RateLimit\ApcuRateLimiter;

class PasswordPolicyAPCu implements PasswordPolicyRateLimiterInterface
{

    public function getLimiter(): ApcuRateLimiter
    {
        return new ApcuRateLimiter();
    }
}