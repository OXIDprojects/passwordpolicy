<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller;

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

        /** @var \OxidEsales\Eshop\Core\InputValidator $oInputValidator */
        $oInputValidator = \OxidEsales\Eshop\Core\Registry::getInputValidator();
        if (($oExcp = $oInputValidator->checkPassword($oUser, $sNewPass, $sConfPass, true))) {
            switch ($oExcp->getMessage()) {
                case \OxidEsales\Eshop\Core\Registry::getLang()->translateString('ERROR_MESSAGE_INPUT_EMPTYPASS'):
                case \OxidEsales\Eshop\Core\Registry::getLang()->translateString('ERROR_MESSAGE_PASSWORD_TOO_SHORT'):
                    return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay(
                        'ERROR_MESSAGE_PASSWORD_TOO_SHORT',
                        false,
                        true
                    );
                case \OxidEsales\Eshop\Core\Registry::getLang()->translateString('OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN'):
                    return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay(
                        'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_PASSWORD_KNOWN',
                        false,
                        true
                    );
                default:
                    return \OxidEsales\Eshop\Core\Registry::getUtilsView()->addErrorToDisplay(
                        'ERROR_MESSAGE_PASSWORD_DO_NOT_MATCH',
                        false,
                        true
                    );
            }
        }

        if (!$sOldPass || !$oUser->isSamePassword($sOldPass)) {
            /** @var \OxidEsales\Eshop\Core\UtilsView $oUtilsView */
            $oUtilsView = \OxidEsales\Eshop\Core\Registry::getUtilsView();

            return $oUtilsView->addErrorToDisplay('ERROR_MESSAGE_CURRENT_PASSWORD_INVALID', false, true);
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