<?php

namespace OxidProfessionalServices\PasswordPolicy\Model;

use OxidEsales\Eshop\Application\Controller\ForgotPasswordController;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\InputValidator;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyValidator;

class User extends User_parent
{
    /**
     * Method is used for overriding and add additional actions when logging in.
     *
     * @param string $userName
     * @param string $password
     */
    public function onLogin($userName, $password)
    {
        /** @var PasswordPolicyValidator $passValidator */
        $passValidator = oxNew(InputValidator::class);
        if (!isAdmin() && $this->isLoaded() && $err = $passValidator->validatePassword($userName, $password)) {
            $forgotPass = new ForgotPasswordController();
            $forgotPass->forgotPassword();
            throw oxNew(UserException::class, $err->getMessage());
        }
        return parent::onLogin($userName,$password);
    }
}