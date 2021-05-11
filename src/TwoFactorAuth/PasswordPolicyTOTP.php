<?php

namespace OxidProfessionalServices\PasswordPolicy\TwoFactorAuth;

use OTPHP\TOTP;
use OxidEsales\Eshop\Core\Registry;

class PasswordPolicyTOTP
{
    /**
     * @return string
     */
    public function getTotpQrUrl(): string
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
     * @param string $secret
     * @param string $auth
     * @return bool returns true if entered auth code is correct, false if not
     */
    public function checkOtp(string $secret, string $auth): bool
    {
        $otp = TOTP::create($secret);
        if($otp->now() == $auth)
        {
            return true;
        }
        return false;
    }
}