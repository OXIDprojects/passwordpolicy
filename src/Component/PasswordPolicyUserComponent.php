<?php

namespace OxidProfessionalServices\PasswordPolicy\Component;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyUserComponent extends PasswordPolicyUserComponent_parent
{
    private string $mode = 'checkout';
    public function createUser()
    {
        $twoFactor = (new Request)->getRequestEscapedParameter('2FA');
        $success = parent::createUser();
        if($twoFactor && $success)
        {
            Registry::getUtils()->redirect(Registry::getConfig()->getShopHomeUrl() . 'cl=twofactor&mode='. $this->mode . '&success='.urlencode($success));
        }
        return $success;


    }

    public function registerUser()
    {
        $this->mode = 'registration';
        return parent::registerUser();
    }

}