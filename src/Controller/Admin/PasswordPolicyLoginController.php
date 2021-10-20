<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;
use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\Registry;


class PasswordPolicyLoginController extends PasswordPolicyLoginController_parent
{
    public function checklogin()
    {
        $myUtilsServer = \OxidEsales\Eshop\Core\Registry::getUtilsServer();
        $myUtilsView = \OxidEsales\Eshop\Core\Registry::getUtilsView();

        $sUser = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('user', true);
        $sPass = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('pwd', true);
        $sProfile = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('profile');

        try { // trying to login
            $session = \OxidEsales\Eshop\Core\Registry::getSession();
            $adminProfiles = $session->getVariable("aAdminProfiles");
            $session->initNewSession();
            $session->setVariable("aAdminProfiles", $adminProfiles);

            /** @var \OxidEsales\Eshop\Application\Model\User $oUser */
            $oUser = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
            $oUser->login($sUser, $sPass);

            if ($oUser->oxuser__oxrights->value === 'user') {
                throw oxNew(UserException::class, 'ERROR_MESSAGE_USER_NOVALIDLOGIN');
            }

            $iSubshop = (int) $oUser->oxuser__oxrights->value;
            if ($iSubshop) {
                \OxidEsales\Eshop\Core\Registry::getSession()->setVariable("shp", $iSubshop);
                \OxidEsales\Eshop\Core\Registry::getSession()->setVariable('currentadminshop', $iSubshop);
                \OxidEsales\Eshop\Core\Registry::getConfig()->setShopId($iSubshop);
            }
        } catch (UserException $oEx) {
            $myUtilsView->addErrorToDisplay($oEx->getMessage());
            $oStr = getStr();
            $this->addTplParam('user', $oStr->htmlspecialchars($sUser));
            $this->addTplParam('pwd', $oStr->htmlspecialchars($sPass));
            $this->addTplParam('profile', $oStr->htmlspecialchars($sProfile));

            return;
        } catch (\OxidEsales\Eshop\Core\Exception\CookieException $oEx) {
            $myUtilsView->addErrorToDisplay($oEx);
            $oStr = getStr();
            $this->addTplParam('user', $oStr->htmlspecialchars($sUser));
            $this->addTplParam('pwd', $oStr->htmlspecialchars($sPass));
            $this->addTplParam('profile', $oStr->htmlspecialchars($sProfile));

            return;
        } catch (\OxidEsales\Eshop\Core\Exception\ConnectionException $oEx) {
            $myUtilsView->addErrorToDisplay($oEx);
        }

        //execute onAdminLogin() event
        $oEvenHandler = oxNew(\OxidEsales\Eshop\Core\SystemEventHandler::class);
        $oEvenHandler->onAdminLogin(\OxidEsales\Eshop\Core\Registry::getConfig()->getShopId());

        // #533
        if (isset($sProfile)) {
            $aProfiles = \OxidEsales\Eshop\Core\Registry::getSession()->getVariable("aAdminProfiles");
            if ($aProfiles && isset($aProfiles[$sProfile])) {
                // setting cookie to store last locally used profile
                $myUtilsServer->setOxCookie("oxidadminprofile", $sProfile . "@" . implode("@", $aProfiles[$sProfile]), time() + 31536000, "/");
                \OxidEsales\Eshop\Core\Registry::getSession()->setVariable("profile", $aProfiles[$sProfile]);
            }
        } else {
            //deleting cookie info, as setting profile to default
            $myUtilsServer->setOxCookie("oxidadminprofile", "", time() - 3600, "/");
        }

        // languages
        $iLang = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter("chlanguage");
        $aLanguages = \OxidEsales\Eshop\Core\Registry::getLang()->getAdminTplLanguageArray();
        if (!isset($aLanguages[$iLang])) {
            $iLang = key($aLanguages);
        }

        $myUtilsServer->setOxCookie("oxidadminlanguage", $aLanguages[$iLang]->abbr, time() + 31536000, "/");


        \OxidEsales\Eshop\Core\Registry::getLang()->setTplLanguage($iLang);


        $secret = $oUser->oxuser__oxpstotpsecret->value;
        if($secret)
        {
            Registry::getSession()->setVariable('tmpusr', $oUser->getId());
            Registry::getSession()->deleteVariable('auth');
            return 'admin_twofactorlogin';
        }
      return 'admin_start';
    }
}