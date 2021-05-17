<?php

namespace OxidProfessionalServices\PasswordPolicy\TwoFactorAuth;

use OTPHP\TOTP;
use OxidEsales\Eshop\Core\Base;
use OxidEsales\Eshop\Core\Registry;

class PasswordPolicyTOTP extends Base
{
    /**
     * @return string
     */
    public function getTOTPQrUrl(): string
    {
        $otp = TOTP::create();
        $user = $this->getUser();
        $secret = $otp->getSecret();
        Registry::getSession()->setVariable('otp_secret', $secret);
        $otp->setLabel($user->oxuser__oxusername->value);
        $otp->setIssuer(Registry::getConfig()->getActiveShop()->getFieldData('oxname'));
        $dataUrl = $otp->getProvisioningUri();
        return $dataUrl;
    }

    /**
     * reads current OTP of the user from the DB and compares it with the entered OTP
     * @param string $secret secret key of entered user
     * @param string $auth entered OTP
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