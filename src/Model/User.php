<?php

namespace OxidProfessionalServices\PasswordPolicy\Model;

use OxidEsales\Eshop\Application\Controller\ForgotPasswordController;
use OxidEsales\Eshop\Core\Exception\UserException;
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
        $check = new PasswordPolicyValidator();
        if ($err = $check->validatePassword($password)) {
            $forgot = new ForgotPasswordController();
            $forgot->forgotPassword();
            throw oxNew(UserException::class, $err->getMessage());
        }
        return parent::onLogin($userName,$password);
    }
}