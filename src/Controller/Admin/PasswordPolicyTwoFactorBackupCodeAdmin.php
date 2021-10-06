<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Field;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyTwoFactorBackupCodeAdmin extends AdminController
{
    public function render()
    {
        parent::render();
        return 'admin_twofactorbackupcode.tpl';
    }

    public function getRedirectLink()
    {
        return 'admin_twofactoraccount?success=1';
    }

    public function generateBackupCode()
    {
        $result = '';
        for($i = 0; $i < 20; $i++) {
            $result .= mt_rand(0, 9);
        }
        $backupCode = password_hash($result, PASSWORD_BCRYPT);
        $user = $this->getUser();
        $user->oxuser__oxpsbackupcode = new Field($backupCode, Field::T_TEXT);
        $user->save();
        return $result;

    }
}