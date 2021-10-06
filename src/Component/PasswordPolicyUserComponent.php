<?php

namespace OxidProfessionalServices\PasswordPolicy\Component;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyUserComponent extends PasswordPolicyUserComponent_parent
{
    const USER_COOKIE_SALT = 'user_cookie_salt';
    private string $step = 'checkout';

    public function createUser()
    {
        $twoFactor = (new Request)->getRequestEscapedParameter('2FA');
        $container = ContainerFactory::getInstance()->getContainer();
        $config = $container->get(PasswordPolicyConfig::class);
        $twofactorconf = $config->isTOTP();
        $paymentActionLink = parent::createUser();
        if($twofactorconf && $twoFactor && $paymentActionLink)
        {
            Registry::getUtils()->redirect(Registry::getConfig()->getShopHomeUrl() . 'cl=twofactorregister&step='. $this->step . '&paymentActionLink='. urlencode($paymentActionLink) . '&success=1');
        }
        return $paymentActionLink;


    }

    public function registerUser()
    {
        $this->step = 'registration';
        return parent::registerUser();
    }
    public function finalizeRegistration()
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $totp = $container->get(PasswordPolicyTOTP::class);
        $otp = (new Request())->getRequestEscapedParameter('otp');
        $secret = Registry::getSession()->getVariable('otp_secret');
        $decryptedsecret = $totp->decryptSecret($secret);
        try {
            $totp->verifyOTP($decryptedsecret, $otp);
            $user = $this->getUser();
            $user->oxuser__oxpstotpsecret = new Field($secret, Field::T_TEXT);
            $user->save();
            //reload user to check if save is successful
            //because even if save returns true the fields may be not stored by oxid
            $user->load($user->getId());
            if ($user->oxuser__oxpstotpsecret->value != $secret) {
                throw oxNew(UserException::class, "OXPS_CANNOTSTOREUSERSECRET");
            }

            //cleans up session for next registration
            Registry::getSession()->deleteVariable('otp_secret');
            $step = (new Request())->getRequestEscapedParameter('step');
            $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
            return 'twofactorbackup?step=' . $step . '&paymentActionLink=' . $paymentActionLink;
        }catch (UserException $ex)
        {
            Registry::getUtilsView()->addErrorToDisplay($ex);
        }
    }

    public function getRedirectLink()
    {
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $redirect = urldecode($paymentActionLink);
        if($step == 'registration')
        {
            $redirect = 'register?success=1';
        }
        elseif($step == 'settings')
        {
            $redirect = 'twofactoraccount?success=1';
        }
        return $redirect;
    }

    public function finalizeLogin()
    {
        $otp = (new Request())->getRequestEscapedParameter('otp');
        $setsessioncookie = (new Request())->getRequestEscapedParameter('setsessioncookie');
        $this->setLoginStatus(USER_LOGIN_FAIL);
        try {
            $user = oxNew(User::class);
            $user->finalizeLogin($otp, $setsessioncookie);
            $user->save();
            $this->setLoginStatus(USER_LOGIN_SUCCESS);
        }catch(UserException $ex)
        {
            return Registry::getUtilsView()->addErrorToDisplay($ex);
        }
        return $this->_afterLogin($user);
    }
}