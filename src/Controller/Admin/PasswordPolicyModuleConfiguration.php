<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;

use Enzoic\Enzoic;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyModuleConfiguration extends PasswordPolicyModuleConfiguration_parent
{
    public function saveConfVars()
    {
        $variables = $this->getConfigVariablesFromRequest();
        if($variables[PasswordPolicyConfig::SETTING_ENZOIC] == "true") {
            $enzoicAPIKey = $variables[PasswordPolicyConfig::SETTING_ENZOIC_API_KEY];
            $enzoicSecretKey = $variables[PasswordPolicyConfig::SETTING_ENZOIC_SECRET_KEY];
            $enzoicApiCon = new Enzoic($enzoicAPIKey, $enzoicSecretKey);

            try {
                $enzoicApiCon->checkPassword("Test");
            } catch (\RuntimeException $ex) {
                Registry::getUtilsView()->addErrorToDisplay("OXPS_PASSWORDPOLICY_ENZOICERROR" . $ex->getCode());
                # needs better solution
                $_POST["confbools"][PasswordPolicyConfig::SETTING_ENZOIC] = "false";
            }
        }
        if($variables[PasswordPolicyConfig::SETTING_ADMIN_USER] == "true")
        {
            $query =  "Select oxusername from oxuser where oxrights != 'user'";
            $result = DatabaseProvider::getDb()->getCol($query);
            $invalidMails = [];
            foreach ($result as $user)
            {
                if(!filter_var($user, FILTER_VALIDATE_EMAIL))
                {
                    $invalidMails[] = $user;
                }
            }
            if(!empty($invalidMails))
            {
                $_POST["confbools"][PasswordPolicyConfig::SETTING_ADMIN_USER] = "false";
                Registry::getUtilsView()->addErrorToDisplay("OXPS_PASSWORDPOLICY_INVALIDADMINUSERS");
                foreach ($invalidMails as $invalidUser)
                {
                    Registry::getUtilsView()->addErrorToDisplay($invalidUser);
                }
            }
        }
        parent::saveConfVars();
    }

    private function getConfigVariablesFromRequest(): array
    {
        $settings = [];

        foreach ($this->_aConfParams as $requestParameterKey) {
            $settingsFromRequest = Registry::getRequest()->getRequestEscapedParameter($requestParameterKey);

            if (\is_array($settingsFromRequest)) {
                foreach ($settingsFromRequest as $name => $value) {
                    $settings[$name] = $value;
                }
            }
        }

        return $settings;
    }
}