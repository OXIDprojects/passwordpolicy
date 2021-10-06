<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\B2BModule\Budget\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyQrCodeRenderer;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyTwoFactorRegisterAdmin extends AdminController
{

    private PasswordPolicyTOTP $TOTP;
    private PasswordPolicyQrCodeRenderer $qrCodeRenderer;
    public function __construct()
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $this->TOTP = $container->get(PasswordPolicyTOTP::class);
        $this->qrCodeRenderer = $container->get(PasswordPolicyQrCodeRenderer::class);
    }

    public function render()
    {
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $success =  (new Request())->getRequestEscapedParameter('success');
        $this->addTplParam('step', $step);
        $this->addTplParam('paymentActionLink', $paymentActionLink);
        $this->addTplParam('success', $success);
        parent::render();
        return 'admin_twofactorregister.tpl';
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
                throw new UserException("OXPS_CANNOTSTOREUSERSECRET");
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

    public function getTOTPQrCode()
    {
        $TOTPurl = $this->TOTP->getTotpQrUrl();
        $qrcode = $this->qrCodeRenderer->generateQrCode($TOTPurl);
        return $qrcode;
    }


}