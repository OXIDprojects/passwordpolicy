<?php

namespace OxidProfessionalServices\PasswordPolicy\Controller\Admin;

use Enzoic\Enzoic;
use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyConfig;

class ModuleConfiguration extends ModuleConfiguration_parent
{
    public function saveConfVars()
    {
        $variables = $this->getConfigVariablesFromRequest();
        $enzoicAPIKey = $variables[PasswordPolicyConfig::SettingEnzoicAPIKey];
        $enzoicSecretKey = $variables[PasswordPolicyConfig::SettingEnzoicSecretKey];
        $enzoicApiCon = new Enzoic($enzoicAPIKey,$enzoicSecretKey);
        $testAPICall = $enzoicApiCon->checkPassword("Test");
        if($testAPICall["status"] != "200")
        {
            Registry::getUtilsView()->addErrorToDisplay(Registry::getLang()->translateString("oxpspasswordpolicy_EnzoicError" . $testAPICall["status"]));
            return;
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