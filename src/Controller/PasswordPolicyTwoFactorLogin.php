<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller;


use OxidEsales\Eshop\Application\Controller\FrontendController;
use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;

class PasswordPolicyTwoFactorLogin extends FrontendController
{
    public function render()
    {
        parent::render();
        $setsessioncookie = (new Request())->getRequestEscapedParameter('setsessioncookie');
        $this->addTplParam('setsessioncookie', $setsessioncookie);
        return 'twofactorlogin.tpl';
    }

    public function getBreadCrumb()
    {
        $aPaths = [];
        $aPath = [];
        $iBaseLanguage = Registry::getLang()->getBaseLanguage();
        $aPath['title'] = Registry::getLang()->translateString('TWOFACTORAUTHLOGIN', $iBaseLanguage, false);
        $aPath['link'] = $this->getLink();
        $aPaths[] = $aPath;
        return $aPaths;
    }
}