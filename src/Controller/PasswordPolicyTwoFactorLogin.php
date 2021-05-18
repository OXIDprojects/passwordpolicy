<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyTwoFactorLogin extends FrontendController
{
    public function render()
    {
        parent::render();
        return 'twofactorlogin.tpl';
    }

    public function finalizeLogin()
    {
        $otp = (new Request())->getRequestEscapedParameter('otp');
        $usr = Registry::getSession()->getVariable('usr2');
        $user = oxNew(User::class);
        $user->load($usr);
        $secret = $user->oxuser__oxtotpsecret->value;
        $TOTP = new PasswordPolicyTOTP();
        $checkOTP = $TOTP->checkOTP($secret, $otp);
        if($checkOTP)
        {
            Registry::getSession()->setVariable('usr', $usr);
        }
    }
}