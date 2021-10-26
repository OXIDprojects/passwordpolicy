<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;

class PasswordPolicyUserMain extends PasswordPolicyUserMain_parent
{

    public function save()
    {
        $soxId = $this->getEditObjectId();
        if ($this->_allowAdminEdit($soxId)) {
            $aParams = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("editval");

            if (!isset($aParams['oxpstwofactor'])) {
                $aParams['oxuser__oxpstotpsecret'] = "";
                $aParams['oxuser__oxpsbackupcode'] = "";

            }
            $_POST['editval'] = $aParams;
        }
        parent::save();
    }


}
