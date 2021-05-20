<?php

namespace OxidProfessionalServices\PasswordPolicy\Component;

use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyUserComponent extends PasswordPolicyUserComponent_parent
{
    const USER_COOKIE_SALT = 'user_cookie_salt';
    private string $step = 'checkout';

    public function createUser()
    {
        $twoFactor = (new Request)->getRequestEscapedParameter('2FA');
        $paymentActionLink = parent::createUser();
        if($twoFactor && $paymentActionLink)
        {
            Registry::getUtils()->redirect(Registry::getConfig()->getShopHomeUrl() . 'cl=twofactorregister&step='. $this->step . '&paymentActionLink='. urlencode($paymentActionLink));
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
        $OTP = (new Request())->getRequestEscapedParameter('otp');
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $secret = Registry::getSession()->getVariable('otp_secret');
        $redirect = urldecode($paymentActionLink);
        if($step == 'registration')
        {
            $redirect = 'register?success=1';
        }

        $checkOTP = $this->TOTP->checkOTP($secret, $OTP);
        if($checkOTP)
        {
            //finalize
            $user = $this->getUser();
            $user->oxuser__oxtotpsecret = new Field($secret, Field::T_TEXT);
            $user->save();
            //cleans up session for next registration
            Registry::getSession()->deleteVariable('otp_secret');
            return $redirect;
        }
        Registry::getUtilsView()->addErrorToDisplay(
            'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP',
            false,
            true
        );

    }
    public function finalizeLogin()
    {
        $config = Registry::getConfig();
        $otp = (new Request())->getRequestEscapedParameter('otp');
        $sessioncookie = (new Request())->getRequestEscapedParameter('setsessioncookie');
        $usr = Registry::getSession()->getVariable('tmpusr');
        $user = oxNew(User::class);
        $user->load($usr);
        $secret = $user->oxuser__oxtotpsecret->value;
        $TOTP = new PasswordPolicyTOTP();
        $checkOTP = $TOTP->checkOTP($secret, $otp);
        if($checkOTP)
        {
            Registry::getSession()->deleteVariable('tmpusr');
            Registry::getSession()->setVariable('usr', $usr);
            $this->setLoginStatus(USER_LOGIN_SUCCESS);
            // in case user wants to stay logged in, setsessioncookie again
            if ($sessioncookie && $config->getConfigParam('blShowRememberMe')) {
                Registry::getUtilsServer()->setUserCookie(
                    $user->oxuser__oxusername->value,
                    $user->oxuser__oxpassword->value,
                    $config->getShopId(),
                    31536000,
                    static::USER_COOKIE_SALT
                );
            }
            $user->set(null);
            $this->_afterLogin($user);
        }
        Registry::getUtilsView()->addErrorToDisplay(
            'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP',
            false,
            true
        );
    }
}