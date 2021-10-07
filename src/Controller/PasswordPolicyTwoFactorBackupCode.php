<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyTwoFactorBackupCode extends FrontendController
{
    public function render()
    {
        $step = (new Request())->getRequestEscapedParameter('step');
        $paymentActionLink = (new Request())->getRequestEscapedParameter('paymentActionLink');
        $this->addTplParam('step', $step);
        $this->addTplParam('paymentActionLink', $paymentActionLink);
        parent::render();
        return 'twofactorbackupcode.tpl';
    }

    public function generateBackupCode()
    {
        $result = '';
        for($i = 0; $i < 20; $i++) {
            $result .= random_int(0,9);
        }
        $backupCode = password_hash($result, PASSWORD_BCRYPT);
        $user = $this->getUser();
        $user->oxuser__oxpsbackupcode = new Field($backupCode, Field::T_TEXT);
        $user->save();
        return $result;

    }
}