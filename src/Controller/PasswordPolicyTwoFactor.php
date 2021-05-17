<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyQrCodeRenderer;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyTwoFactor extends FrontendController
{

    public function render()
    {
        $mode = (new Request())->getRequestEscapedParameter('mode');
        $success = (new Request())->getRequestEscapedParameter('success');
        $this->addTplParam('mode',$mode);
        $this->addTplParam('success', $success);
        parent::render();
        return 'twofactor.tpl';
    }

    public function finalizeRegistration()
    {
        $OTP = (new Request())->getRequestEscapedParameter('otp');
        $mode = (new Request())->getRequestEscapedParameter('mode');
        $success = (new Request())->getRequestEscapedParameter('success');
        $secret = Registry::getSession()->getVariable('otp_secret');
        if($mode == 'registration')
        {
            $redirect = 'register?success=1';
        }
        else
        {
            $redirect = urldecode($success);
        }
        $TOTP = new PasswordPolicyTOTP();
        $checkOTP = $TOTP->checkOTP($secret, $OTP);
        if($checkOTP)
        {
            //finalize
            $user = $this->getUser();
            $user->oxuser__oxotps = new Field($secret, Field::T_TEXT);
            $user->save();
            return $redirect;
        }
        \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay(
            'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP',
            false,
            true
        );

    }
    public function getTOTPQrCode()
    {
        $TOTP = new PasswordPolicyTOTP();
        $TOTPurl = $TOTP->getTotpQrUrl();
        $qrrenderer = new PasswordPolicyQrCodeRenderer();
        $qrcode = $qrrenderer->generateQrCode($TOTPurl);
        return $qrcode;
    }
}