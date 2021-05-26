<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidEsales\EshopCommunity\Core\Field;

class PasswordPolicyTwoFactorRecovery extends FrontendController
{
    private $session;
    private $usr;
    private User $user;

    /**
     * PasswordPolicyTwoFactorRecovery constructor.
     */
    public function __construct()
    {
        $this->session = Registry::getSession();
        $this->usr = $this->session->getVariable('tmpusr');
        $this->user = oxNew(User::class);
        $this->user->load($this->usr);
    }

    public function render()
    {
        parent::render();
        return 'twofactorrecovery.tpl';
    }
    public function redirect()
    {
        if($this->checkCode())
        {
            $this->resetCode();
            $this->session->setVariable('usr', $this->usr);
            return 'start';
        }
        Registry::getUtilsView()->addErrorToDisplay('OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGBACKUPCODE');
    }
    public function resetCode()
    {
        $this->user->oxuser__oxpstotpsecret = new Field("", Field::T_TEXT);
        $this->user->oxuser__oxpsbackupcode = new Field("", Field::T_TEXT);
        $this->user->save();
    }
    public function checkCode()
    {
        $recoveryCode = (new Request())->getRequestEscapedParameter('recoveryCode');
        $userRecoveryCode = $this->user->oxuser__oxpsbackupcode->value;
        if(password_verify($recoveryCode, $userRecoveryCode))
        {
            return true;
        }
        return false;
    }
}