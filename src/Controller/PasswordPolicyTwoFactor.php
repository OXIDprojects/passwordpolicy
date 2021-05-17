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
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $this->addTplParam('step', $step);
        $this->addTplParam('paymentActionLink', $paymentActionLink);
        parent::render();
        return 'twofactor.tpl';
    }

    public function finalizeRegistration()
    {
        $OTP = (new Request())->getRequestEscapedParameter('otp');
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $secret = Registry::getSession()->getVariable('otp_secret');
        if($step == 'registration')
        {
            $redirect = 'register?success=1';
        }
        else
        {
            $redirect = urldecode($paymentActionLink);
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

    public function getBreadCrumb()
    {
        $aPath['title'] = Registry::getLang()->translateString('TWOFACTORAUTH');
        $aPath['link'] = $this->getLink();
        $aPaths[] = $aPath;
        return $aPaths;
    }
}