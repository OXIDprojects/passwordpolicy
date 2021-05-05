<?php


namespace OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter;


interface PasswordPolicyRateLimiterInterface
{
    public function getLimiter();
}