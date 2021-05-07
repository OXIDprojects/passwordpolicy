<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;

use Enzoic\AuthenticationException;
use Enzoic\Enzoic;
use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class PasswordPolicyModuleConfiguration extends PasswordPolicyModuleConfiguration_parent
{
    public function saveConfVars()
    {
        $variables = $this->getConfigVariablesFromRequest();
        if($variables[PasswordPolicyConfig::SettingEnzoic] == "true") {
            $enzoicAPIKey = $variables[PasswordPolicyConfig::SettingEnzoicAPIKey];
            $enzoicSecretKey = $variables[PasswordPolicyConfig::SettingEnzoicSecretKey];
            $enzoicApiCon = new Enzoic($enzoicAPIKey, $enzoicSecretKey);

            try {
                $enzoicApiCon->checkPassword("Test");
            } catch (\RuntimeException $ex) {
                Registry::getUtilsView()->addErrorToDisplay("OXPS_PASSWORDPOLICY_ENZOICERROR" . $ex->getCode());
                # needs better solution
                $_POST["confbools"][PasswordPolicyConfig::SettingEnzoic] = "false";
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