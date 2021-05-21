<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyTwoFactorConfirmation extends FrontendController
{
    public function render()
    {
        parent::render();
        $oUser = $this->getUser();
        if (!$oUser) {
            return 'page/account/login.tpl';
        }
        return 'twofactorconfirmation.tpl';
    }

    public function confirm()
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $TOTP = $container->get(PasswordPolicyTOTP::class);
        $otp = (new Request())->getRequestEscapedParameter('otp');
        $user = $this->getUser();
        $secret = $user->oxuser__oxtotpsecret->value;
        $checkOTP = $TOTP->checkOTP($secret, $otp);
        if($checkOTP)
        {
            // resets 2FA secret code for user
            $user->oxuser__oxtotpsecret = new Field("", Field::T_TEXT);
            $user->save();
            return 'twofactoraccount?success=2';
        }
        Registry::getUtilsView()->addErrorToDisplay(
            'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP',
            false,
            true
        );
    }

    public function getBreadCrumb()
    {
        $aPaths = [];
        $aPath = [];
        $iBaseLanguage = Registry::getLang()->getBaseLanguage();
        $aPath['title'] = Registry::getLang()->translateString('TWOFACTORAUTHLOGIN', $iBaseLanguage, false);
        $aPath['link'] = $this->getLink();
        $aPaths[] = $aPath;
        return $aPaths;
    }
}