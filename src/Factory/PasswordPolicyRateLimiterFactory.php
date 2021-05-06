<?php

namespace OxidProfessionalServices\PasswordPolicy\Factory;

use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\Exception\LimiterNotFound;
use OxidProfessionalServices\PasswordPolicy\Factory\RateLimiter\PasswordPolicyRateLimiterInterface;
use Psr\Container\NotFoundExceptionInterface;

class PasswordPolicyRateLimiterFactory
{
    /**
     * @param string $limiter
     * @return PasswordPolicyRateLimiterInterface
     * @throws LimiterNotFound
     */
    public function getRateLimiter(string $limiter): PasswordPolicyRateLimiterInterface
    {
        $class = 'PasswordPolicy' . $limiter;
        $container = ContainerFactory::getInstance()->getContainer();
        try {
            $driver = $container->get($class);
        }
        catch (NotFoundExceptionInterface $ex)
        {
            throw new LimiterNotFound();
        }
        return $driver;
    }
}