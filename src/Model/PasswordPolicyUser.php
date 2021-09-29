<?php

namespace OxidProfessionalServices\PasswordPolicy\Model;

use OxidEsales\Eshop\Application\Controller\ForgotPasswordController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\InputValidator;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyValidator;
use OxidProfessionalServices\PasswordPolicy\Exception\LimiterNotFound;
use OxidProfessionalServices\PasswordPolicy\Factory\PasswordPolicyRateLimiterFactory;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;
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
        if ($this->isLoaded() && $err = $passValidator->validatePassword($userName, $password)) {
            if(!$this->isAdmin()) {
                $forgotPass = new ForgotPasswordController();
                $forgotPass->forgotPassword();
                $errorMessage = $err->getMessage() . '&nbsp' . Registry::getLang()->translateString('REQUEST_PASSWORD_AFTERCLICK');
                throw oxNew(UserException::class, $errorMessage);
            }
            // redirects admin to password reset page *temporary solution
            $oViewConf = oxNew(ViewConfig::class);
            $passwordResetLink = $oViewConf->getBaseDir() . 'index.php?cl=forgotpwd&uid=' . $this->getUpdateId() . '&lang=' . $oViewConf->getActLanguageId() . '&shp=' . $this->getShopId();
            \OxidEsales\EshopCommunity\Core\Registry::getUtilsView()->addErrorToDisplay("Test");
            Registry::getUtils()->redirect($passwordResetLink, true, 302);

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
        if ($config->isRateLimiting()) {
            $driverName = $config->getSelectedDriver();
            $rateLimiter = (new PasswordPolicyRateLimiterFactory())->getRateLimiter($driverName)->getLimiter();
            // checks whether rate limit is exceeded
            try {
                $rateLimiter->limit($userName, Rate::perMinute($config->getRateLimit()));
            } catch (LimitExceeded $exception) {
                throw oxNew(UserException::class, 'OXPS_PASSWORDPOLICY_RATELIMIT_EXCEEDED');
            }
        }
        parent::login($userName, $password, $setSessionCookie);
        $sessionuser =  Registry::getSession()->getVariable('usr');
        $user = oxNew(User::class);
        $user->load($sessionuser);
        $secret = $user->oxuser__oxpstotpsecret->value;
        // checks if user has 2FA enabled and is not admin
        if(!isAdmin() && $secret)
        {
            Registry::getSession()->deleteVariable('usr');
            Registry::getUtilsServer()->deleteUserCookie();
            Registry::getSession()->setVariable('tmpusr', $sessionuser);
            Registry::getUtils()->redirect(Registry::getConfig()->getShopHomeUrl() . 'cl=twofactorlogin&setsessioncookie=' . $setSessionCookie);
        }

    }

    public function finalizeLogin($otp, $setsessioncookie = false)
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $totp = $container->get(PasswordPolicyTOTP::class);
        $config = $container->get(Config::class);
        $session = Registry::getSession();
        $usr = $session->getVariable('tmpusr');
        $this->load($usr);
        $secret = $this->oxuser__oxpstotpsecret->value;
        $decryptedSecret = $totp->decryptSecret($secret);
        $totp->verifyOTP($decryptedSecret, $otp, $this);
        $this->oxuser__oxpsotp = new Field($otp, Field::T_TEXT);
        $session->deleteVariable('tmpusr');
        $session->setVariable('usr', $usr);
        // in case user wants to stay logged in, set user cookie again
        if ($setsessioncookie && $config->getConfigParam('blShowRememberMe')) {
            Registry::getUtilsServer()->setUserCookie(
            $this->oxuser__oxusername->value,
            $this->oxuser__oxpassword->value,
            $config->getShopId(),
            31536000,
                    static::USER_COOKIE_SALT
                );
            }
        return $this;
        }
}
