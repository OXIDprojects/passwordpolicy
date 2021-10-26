<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\AccountController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyAccountTOTP extends AccountController
{
    public function render()
    {
        parent::render();
        $oUser = $this->getUser();
        if (!$oUser) {
            return $this->_sThisLoginTemplate;
        }
        $success = (new Request())->getRequestEscapedParameter('success');
        $this->addTplParam('success', $success);
        return 'twofactoraccount.tpl';
    }

    public function getBreadCrumb()
    {
        $aPaths = [];
        $aPath = [];
        $oUtils = Registry::getUtilsUrl();
        $iBaseLanguage = Registry::getLang()->getBaseLanguage();
        $sSelfLink = $this->getViewConfig()->getSelfLink();

        $aPath['title'] = Registry::getLang()->translateString('MY_ACCOUNT', $iBaseLanguage, false);
        $aPath['link'] = Registry::getSeoEncoder()->getStaticUrl($sSelfLink . 'cl=account');
        $aPaths[] = $aPath;

        $aPath['title'] = Registry::getLang()->translateString('OXPS_PASSWORDPOLICY_TWOFACTORAUTH_LOGIN', $iBaseLanguage, false);
        $aPath['link'] = $oUtils->cleanUrl($this->getLink(), ['fnc']);
        $aPaths[] = $aPath;

        return $aPaths;
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
            return 'twofactorregister?step=settings';
        }
        elseif (!$totpenabled && $this->isTOTP())
        {
            return 'twofactorconfirmation';
        }
    }
}