<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Config;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Internal\Container\ContainerFactory;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;
use OxidProfessionalServices\PasswordPolicy\Factory\PasswordPolicyRateLimiterFactory;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;
use RateLimit\Exception\LimitExceeded;
use RateLimit\Rate;

class PasswordPolicyTwoFactorLoginAdmin extends AdminController
{
    public function render()
    {
        parent::render();
        return 'admin_twofactorlogin.tpl';
    }

    public function finalizeLogin()
    {
        $otp = (new Request())->getRequestEscapedParameter('otp');
        try {
            $user = oxNew(User::class);
            $user->finalizeLogin($otp, false);
            $user->save();
        }catch(UserException $ex)
        {
            return Registry::getUtilsView()->addErrorToDisplay($ex);
        }
        return 'admin_start';
    }

    protected function _authorize()
    {
        return true;
    }

}