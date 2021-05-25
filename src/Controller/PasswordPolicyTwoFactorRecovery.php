<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyTwoFactorRecovery extends FrontendController
{
    public function render()
    {
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $this->addTplParam('step', $step);
        $this->addTplParam('paymentActionLink', $paymentActionLink);
        parent::render();
        return 'twofactorrecovery.tpl';
    }

    public function generateBackupCode()
    {
        $result = '';
        for($i = 0; $i < 20; $i++) {
            $result .= mt_rand(0, 9);
        }
        $user = $this->getUser();
        $user->oxuser__oxpsbackupcode = new Field($result, Field::T_TEXT);
        $user->save();
        return $result;

    }
}