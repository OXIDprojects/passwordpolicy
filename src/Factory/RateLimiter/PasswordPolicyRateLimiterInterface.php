<?php


namespace OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter;


use RateLimit\RateLimiter;

interface PasswordPolicyRateLimiterInterface
{
    public function getLimiter() : RateLimiter;
}