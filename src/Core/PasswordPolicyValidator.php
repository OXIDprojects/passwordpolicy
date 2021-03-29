<?php


namespace OxidProfessionalServices\PasswordPolicy\Core;


use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\Exception\InputException;
use OxidEsales\Eshop\Core\Exception\StandardException;
use OxidEsales\Eshop\Core\Registry;

class PasswordPolicyValidator extends PasswordPolicyValidator_parent
{
    /**
     * @param User $user
     * @param string $newPassword
     * @param string $confirmationPassword
     * @param false $shouldCheckPasswordLength
     * @return StandardException|\OxidEsales\EshopCommunity\Core\Exception\StandardException|null
     */
    public function checkPassword($user, $newPassword, $confirmationPassword, $shouldCheckPasswordLength = false)
    {
        $ex = $this->validatePassword($newPassword);
        if (isset($ex)) {
            return $ex;
        }
        return parent::checkPassword($user, $newPassword, $confirmationPassword, $shouldCheckPasswordLength);
    }

    public function getModuleSettings()
    {
        return Registry::get(PasswordPolicyConfig::class)->getModuleSettings();
    }

    /**
     * Validate password with password policy rules.
     *
     * @param string $sPassword
     * @return null|StandardException
     */
    public function validatePassword(string $sPassword): ?StandardException
    {
        $sPassword = (string)$sPassword;
        $sError = '';
        $iPasswordLength = mb_strlen($sPassword, 'UTF-8');

        // Load module settings
        $aSettings = $this->getModuleSettings();

        // Validate password according to settings params
        if ($iPasswordLength < $aSettings['iMinPasswordLength']) {
            $sError = 'ERROR_MESSAGE_PASSWORD_TOO_SHORT';
        }

        if ($iPasswordLength > $aSettings['iMaxPasswordLength']) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_TOOLONG';
        }

        if (!empty($aSettings['aPasswordRequirements']['digits']) and !preg_match('(\d+)', $sPassword)) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESDIGITS';
        }

        if (!empty($aSettings['aPasswordRequirements']['capital']) and !preg_match('(\p{Lu}+)', $sPassword)) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESCAPITAL';
        }

        if (!empty($aSettings['aPasswordRequirements']['lower']) and !preg_match('(\p{Ll}+)', $sPassword)) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESLOWER';
        }

        if (
            !empty($aSettings['aPasswordRequirements']['special']) and
            !preg_match('([\.,_@\~\(\)\!\#\$%\^\&\*\+=\-\\\/|:;`]+)', $sPassword)
        ) {
            $sError = 'OXPS_PASSWORDPOLICY_PASSWORDSTRENGTH_ERROR_REQUIRESSPECIAL';
        }

        $res = null;
        if (!empty($sError)) {
            $translateString = Registry::getLang()->translateString($sError);
            $exception = oxNew(InputException::class, $translateString);

            $res = $this->addValidationError("oxuser__oxpassword", $exception);
        }

        return $res;
    }

}