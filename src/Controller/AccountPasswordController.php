<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller;

use OxidEsales\Eshop\Core\InputValidator;

class AccountPasswordController extends AccountPasswordController_parent
{
    /**
     * changes current user password
     *
     * @return null
     */
    public function changePassword()
    {
        if (!\OxidEsales\Eshop\Core\Registry::getSession()->checkSessionChallenge()) {
            return;
        }

        $oUser = $this->getUser();
        if (!$oUser) {
            return;
        }

        $sOldPass = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('password_old', true);
        $sNewPass = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('password_new', true);
        $sConfPass = \OxidEsales\Eshop\Core\Registry::getConfig()->getRequestParameter('password_new_confirm', true);

        if (!$sOldPass || !$oUser->isSamePassword($sOldPass)) {
            /** @var \OxidEsales\Eshop\Core\UtilsView $oUtilsView */
            $oUtilsView = \OxidEsales\Eshop\Core\Registry::getUtilsView();

            return $oUtilsView->addErrorToDisplay('ERROR_MESSAGE_CURRENT_PASSWORD_INVALID', false, true);
        }

        /** @var \OxidEsales\Eshop\Core\InputValidator $oInputValidator */
        $oInputValidator = \OxidEsales\Eshop\Core\Registry::getInputValidator();

        if (($oExcp = $oInputValidator->checkPassword($oUser, $sNewPass, $sConfPass, true))) {
            $tmpInputValidator = oxNew(InputValidator::class);
            \OxidEsales\Eshop\Core\Registry::set(InputValidator::class, $tmpInputValidator);
                    return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay(
                        $oExcp,
                        false,
                        true
                    );
        }


        // testing passed - changing password
        $oUser->setPassword($sNewPass);
        if ($oUser->save()) {
            $this->_blPasswordChanged = true;
            // deleting user autologin cookies.
            \OxidEsales\Eshop\Core\Registry::getUtilsServer()->deleteUserCookie($this->getConfig()->getShopId());
        }
    }

}