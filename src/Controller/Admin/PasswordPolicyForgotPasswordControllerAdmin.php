<?php


namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;


use OxidEsales\Eshop\Application\Controller\Admin\AdminController;
use OxidEsales\Eshop\Core\Registry;

class PasswordPolicyForgotPasswordControllerAdmin extends AdminController
{
    protected $_sForgotEmail = null;

    public function render()
    {
        return 'forgotpwd.tpl';

    }

    public function forgotPassword()
    {
        $sEmail = Registry::getConfig()->getRequestParameter('user');
        $this->_sForgotEmail = $sEmail;
        $oEmail = oxNew(\OxidEsales\Eshop\Core\Email::class);

        // problems sending passwd reminder ?
        $iSuccess = false;
        if ($sEmail) {
            $iSuccess = $oEmail->sendForgotPwdEmail($sEmail);
        }
        if ($iSuccess !== true) {
            $sError = ($iSuccess === false) ? 'ERROR_MESSAGE_PASSWORD_EMAIL_INVALID' : 'MESSAGE_NOT_ABLE_TO_SEND_EMAIL';
            Registry::getUtilsView()->addErrorToDisplay($sError);
            $this->_sForgotEmail = false;
        }
    }
    public function updatePassword()
    {
        $sNewPass = Registry::getConfig()->getRequestParameter('password_new', true);
        $sConfPass = Registry::getConfig()->getRequestParameter('password_new_confirm', true);

        $oUser = oxNew(\OxidEsales\Eshop\Application\Model\User::class);

        /** @var \OxidEsales\Eshop\Core\InputValidator $oInputValidator */
        $oInputValidator = Registry::getInputValidator();
        if (($oExcp = $oInputValidator->checkPassword($oUser, $sNewPass, $sConfPass, true))) {
            return Registry::getUtilsView()->addErrorToDisplay($oExcp->getMessage(), false, true);
        }

        // passwords are fine - updating and loggin user in
        if ($oUser->loadUserByUpdateId($this->getUpdateId())) {
            // setting new pass ..
            $oUser->setPassword($sNewPass);

            // resetting update pass params
            $oUser->setUpdateKey(true);

            // saving ..
            $oUser->save();

            // forcing user login
            Registry::getSession()->setVariable('auth', $oUser->getId());

            return 'admin_start';
        } else {
            // expired reminder
            $oUtilsView = Registry::getUtilsView();

            return $oUtilsView->addErrorToDisplay('ERROR_MESSAGE_PASSWORD_LINK_EXPIRED', false, true);
        }
    }

    /**
     * If user password update was successfull - setting success status
     *
     * @return bool
     */
    public function updateSuccess()
    {
        return (bool) Registry::getConfig()->getRequestParameter('success');
    }

    /**
     * Notifies that password update form must be shown
     *
     * @return bool
     */
    public function showUpdateScreen()
    {
        return (bool) $this->getUpdateId();
    }

    /**
     * Returns special id used for password update functionality
     *
     * @return string
     */
    public function getUpdateId()
    {
        return Registry::getConfig()->getRequestParameter('uid');
    }

    /**
     * Returns password update link expiration status
     *
     * @return bool
     */
    public function isExpiredLink()
    {
        if (($sKey = $this->getUpdateId())) {
            $blExpired = oxNew(\OxidEsales\Eshop\Application\Model\User::class)->isExpiredUpdateId($sKey);
        }

        return $blExpired;
    }

    /**
     * Template variable getter. Returns searched article list
     *
     * @return string
     */
    public function getForgotEmail()
    {
        return $this->_sForgotEmail;
    }


    /**
     * Get password reminder page title
     *
     * @return string
     */
    public function getTitle()
    {
        $sTitle = 'FORGOT_PASSWORD';

        if ($this->showUpdateScreen()) {
            $sTitle = 'NEW_PASSWORD';
        } elseif ($this->updateSuccess()) {
            $sTitle = 'CHANGE_PASSWORD';
        }

        return Registry::getLang()->translateString($sTitle, Registry::getLang()->getBaseLanguage(), false);
    }

    protected function _authorize()
    {
        return true;
    }
}