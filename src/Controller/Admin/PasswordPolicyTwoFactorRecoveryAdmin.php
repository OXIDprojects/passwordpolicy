<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;

class PasswordPolicyTwoFactorRecoveryAdmin extends AdminController
{
    public function render()
    {
        parent::render();
        return 'admin_twofactorrecovery.tpl';
    }
    public function redirect()
    {
        $redirect = 'admin_twofactoraccount?success=2';
        $recoveryCode = (new Request())->getRequestEscapedParameter('recoveryCode');
        $session = Registry::getSession();
        $user = $this->getUser();
        $usr = $session->getVariable('tmpusr') ?: $user->getId();
        if(!$user)
        {
            $user = oxNew(User::class);
            $user->load($usr);
            $redirect = 'admin_start';
        }
        if($this->checkCode($user, $recoveryCode))
        {
            $this->resetCode($user);
            $session->setVariable('auth', $usr);
            return $redirect;
        }
        Registry::getUtilsView()->addErrorToDisplay('OXPS_PASSWORDPOLICY_TWOFACTORAUTH_ERROR_WRONGBACKUPCODE');
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

    protected function _authorize()
    {
        return true;
    }
}