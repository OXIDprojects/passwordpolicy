<?php


namespace OxidProfessionalServices\PasswordPolicy\Validators;


use OxidEsales\Eshop\Core\Registry;
use OxidEsales\Eshop\Core\Request;
use OxidProfessionalServices\PasswordPolicy\TwoFactorAuth\PasswordPolicyTOTP;

class PasswordPolicyOTP
{
    public function validate(string $sUsername, string $sPassword)
    {
        $user = oxNew(\OxidEsales\Eshop\Application\Model\User::class);
        $user->loadUserByUsername($sUsername);
        $TOTP= new PasswordPolicyTOTP();
        $userOTP = $user->oxuser__oxotp->value?: Registry::getSession()->getVariable('otp_secret');
        $auth = (new Request)->getRequestEscapedParameter('lgn_auth');
        if(!$TOTP->checkOtp($userOTP,$auth))
        {
            return 'OXPS_PASSWORDPOLICY_TOTP_ERROR_WRONGOTP';
        }
        return true;

    }
}