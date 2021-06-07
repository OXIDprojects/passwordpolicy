<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;

class PasswordPolicyTwoFactorRecovery extends FrontendController
{
    public function render()
    {
        parent::render();
        return 'twofactorrecovery.tpl';
    }
    public function redirect()
    {
        $recoveryCode = (new Request())->getRequestEscapedParameter('recoveryCode');
        $session = Registry::getSession();
        $usr = $session->getVariable('tmpusr');
        $user = oxNew(User::class);
        $user->load($usr);
        if($this->checkCode($user, $recoveryCode))
        {
            $this->resetCode($user);
            $session->setVariable('usr', $usr);
            return 'start';
        }
        Registry::getUtilsView()->addErrorToDisplay('OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGBACKUPCODE');
    }

    public function resetCode($user)
    {
        $user->oxuser__oxpstotpsecret = new Field("", Field::T_TEXT);
        $user->oxuser__oxpsbackupcode = new Field("", Field::T_TEXT);
        $user->save();
    }

    public function checkCode($user, $recoveryCode)
    {
        $userRecoveryCode = $user->oxuser__oxpsbackupcode->value;
        if(password_verify($recoveryCode, $userRecoveryCode))
        {
            return true;
        }
        return false;
    }
}