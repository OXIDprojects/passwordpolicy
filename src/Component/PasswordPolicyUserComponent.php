<?php

namespace OxidProfessionalServices\PasswordPolicy\Component;

use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyUserComponent extends PasswordPolicyUserComponent_parent
{
    private string $step = 'checkout';
    public function createUser()
    {
        $twoFactor = (new Request)->getRequestEscapedParameter('2FA');
        $paymentActionLink = parent::createUser();
        if($twoFactor && $paymentActionLink)
        {
            Registry::getUtils()->redirect(Registry::getConfig()->getShopHomeUrl() . 'cl=twofactorregister&step='. $this->step . '&paymentActionLink='. urlencode($paymentActionLink));
        }
        return $paymentActionLink;


    }

    public function registerUser()
    {
        $this->step = 'registration';
        return parent::registerUser();
    }

}