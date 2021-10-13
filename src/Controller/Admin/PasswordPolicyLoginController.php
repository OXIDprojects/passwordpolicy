<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;


class PasswordPolicyLoginController extends PasswordPolicyLoginController_parent
{
    public function checklogin()
    {
        parent::checklogin();
        $sessionuser =  Registry::getSession()->getVariable('auth');
        $user = oxNew(User::class);
        $user->load($sessionuser);
        $secret = $user->oxuser__oxpstotpsecret->value;
        if($secret)
        {
            Registry::getSession()->setVariable('tmpusr', $sessionuser);
            Registry::getSession()->deleteVariable('auth');
            return 'admin_twofactorlogin';
        }
      return 'admin_start';
    }
}