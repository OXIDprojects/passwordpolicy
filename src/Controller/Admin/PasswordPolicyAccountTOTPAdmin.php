<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyAccountTOTPAdmin extends AdminController
{
    public function render()
    {
        parent::render();
        return 'admin_twofactoraccount.tpl';
    }



    public function isTOTP(): bool
    {
        $user = $this->getUser();
        $secret = $user->oxuser__oxpstotpsecret->value;
        return $secret != null;
    }

    public function redirect()
    {
        $totpenabled = (new Request())->getRequestEscapedParameter('status');
        if ($totpenabled && !$this->isTOTP()) {
            //avoid predefined otp_secret (by attacker with temp access)
            Registry::getSession()->deleteVariable('otp_secret');
            \OxidEsales\Eshop\Core\Registry::getUtils()->redirect($this->getViewConfig()->getSelfLink() . 'cl=admin_twofactorregister&step=settings');
        }
        elseif (!$totpenabled && $this->isTOTP())
        {
            return 'twofactorconfirmation';
        }
    }
}