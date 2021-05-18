<?php

namespace OxidProfessionalServices\PasswordPolicy\Model;

use OxidEsales\Eshop\Application\Controller\ForgotPasswordController;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\InputValidator;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyValidator;
use OxidProfessionalServices\PasswordPolicy\Exception\LimiterNotFound;
use OxidProfessionalServices\PasswordPolicy\Factory\PasswordPolicyRateLimiterFactory;
use RateLimit\Exception\LimitExceeded;
use RateLimit\Rate;

class PasswordPolicyUser extends PasswordPolicyUser_parent
{
    /**
     * Method is used for overriding and add additional actions when logging in.
     *
     * @param string $userName
     * @param string $password
     * @throws UserException
     */
    public function onLogin($userName, $password)
    {
        /** @var PasswordPolicyValidator $passValidator */
        $passValidator = oxNew(InputValidator::class);
        if (!isAdmin() && $this->isLoaded() && $err = $passValidator->validatePassword($userName, $password)) {
            $forgotPass = new ForgotPasswordController();
            $forgotPass->forgotPassword();
            $errorMessage = $err->getMessage() . '&nbsp' . Registry::getLang()->translateString('REQUEST_PASSWORD_AFTERCLICK');
            throw oxNew(UserException::class, $errorMessage);
        }
        parent::onLogin($userName, $password);
    }

    /**
     * @param string $userName
     * @param string $password
     * @param bool $setSessionCookie
     * @return void
     * @throws UserException|
     * @throws LimiterNotFound
     */
    public function login($userName, $password, $setSessionCookie = false)
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $config = $container->get(PasswordPolicyConfig::class);
        if ($config->getRateLimitingNeeded()) {
            $driverName = $config->getSelectedDriver();
            $rateLimiter = (new PasswordPolicyRateLimiterFactory())->getRateLimiter($driverName)->getLimiter();

            try {
                $rateLimiter->limit($userName, Rate::perMinute($config->getRateLimit()));
            } catch (LimitExceeded $exception) {
                throw oxNew(UserException::class, 'OXPS_PASSWORDPOLICY_RATELIMIT_EXCEEDED');
            }
        }
        parent::login($userName, $password, $setSessionCookie);
        if(!isAdmin())
        {
            $sessionuser =  Registry::getSession()->getVariable('usr');
            Registry::getSession()->deleteVariable('usr');
            Registry::getSession()->setVariable('tmpusr', $sessionuser);
            Registry::getUtils()->redirect(Registry::getConfig()->getShopHomeUrl() . 'cl=twofactorlogin');
        }

    }
}
