<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyTwoFactorConfirmationAdmin extends AdminController
{
    public function render()
    {
        parent::render();
        $oUser = $this->getUser();
        if (!$oUser) {
            return 'page/account/login.tpl';
        }
        return 'admin_twofactorconfirmation.tpl';
    }

    public function confirm()
    {
        $container = ContainerFactory::getInstance()->getContainer();
        $TOTP = $container->get(PasswordPolicyTOTP::class);
        $otp = (new Request())->getRequestEscapedParameter('otp');
        $user = $this->getUser();
        $secret = $user->oxuser__oxpstotpsecret->value;
        $decryptedSecret = $TOTP->decryptSecret($secret);
        try {
            $TOTP->verifyOTP($decryptedSecret, $otp, $user);
            // resets 2FA secret code for user
            $user->oxuser__oxpstotpsecret = new Field("", Field::T_TEXT);
            $user->oxuser__oxpsbackupcode = new Field("", Field::T_TEXT);
            $user->save();
            return 'admin_twofactoraccount?success=2';
        }catch (UserException $ex)
        {
            Registry::getUtilsView()->addErrorToDisplay($ex);
        }

    }

}