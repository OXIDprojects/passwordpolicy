<?php

namespace OxidProfessionalServices\PasswordPolicy\TwoFactorAuth;

use OTPHP\TOTP;
use OxidEsales\Eshop\Core\Registry;

class PasswordPolicyTOTP
{
    /**
     * @return string
     */
    public function getTOTPQrUrl(): string
    {
        $otp = TOTP::create();
        $secret = $otp->getSecret();
        Registry::getSession()->setVariable('otp_secret', $secret);
        $label = Registry::getConfig()->getShopUrl();
        $otp->setLabel(str_replace('/','',preg_replace('#http://#','',$label)));
        $dataUrl = $otp->getProvisioningUri();
        return $dataUrl;
    }

    /**
     * reads current OTP of the user from the DB and compares it with the entered OTP
     * @param string $secret
     * @param string $auth
     * @return bool returns true if entered OTP is correct, false if not
     */
    public function checkOTP(string $secret, string $auth): bool
    {
        $otp = TOTP::create($secret);
        if($otp->now() == $auth)
        {
            return true;
        }
        return false;
    }
}