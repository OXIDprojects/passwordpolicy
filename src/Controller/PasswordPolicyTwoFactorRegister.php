<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyQrCodeRenderer;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyTwoFactorRegister extends FrontendController
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
        $this->addTplParam('step', $step);
        $this->addTplParam('paymentActionLink', $paymentActionLink);
        parent::render();
        return 'twofactorregister.tpl';
    }

    public function getTOTPQrCode()
    {
        $TOTPurl = $this->TOTP->getTotpQrUrl();
        $qrcode = $this->qrCodeRenderer->generateQrCode($TOTPurl);
        return $qrcode;
    }

    public function getBreadCrumb()
    {
        $aPaths = [];
        $aPath = [];
        $iBaseLanguage = Registry::getLang()->getBaseLanguage();
        $aPath['title'] = Registry::getLang()->translateString('TWOFACTORAUTH', $iBaseLanguage, false);
        $aPath['link'] = $this->getLink();
        $aPaths[] = $aPath;
        return $aPaths;
    }
}