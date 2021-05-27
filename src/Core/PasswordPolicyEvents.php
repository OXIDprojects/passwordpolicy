<?php


namespace OxidProfessionalServices\PasswordPolicy\Core;


use OxidEsales\Eshop\Core\DbMetaDataHandler;
use OxidEsales\Eshop\Core\ViewConfig;

class PasswordPolicyEvents
{
    public static function onActivate()
    {
        $query = "ALTER TABLE oxuser ADD OXPSTOTPSECRET varchar(255) NOT NULL,
                                     ADD OXPSBACKUPCODE varchar(255) NOT NULL;";
        try {
            \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->execute($query);
            self::regenerateViews();
        }catch (\Exception $exception)
        {
        }
            $viewConf = oxNew(ViewConfig::class);
            $modulePath = $viewConf->getModulePath('oxpspasswordpolicy');
            $file = 'twofactor.config.inc.php';
            if(!file_exists($modulePath . $file))
            {
                file_put_contents($modulePath . $file, '<?php 
$this->key=' . 'self::generateKey();');
            }
    }

    /**
     * Regenerate views for changed tables
     */

    protected static function generateKey()
    {
        $key = openssl_random_pseudo_bytes(32);
        $hashedKey = base64_encode($key);
        return $hashedKey;
    }
    protected static function regenerateViews()
    {
        $oDbMetaDataHandler = oxNew(DbMetaDataHandler::class );
        $oDbMetaDataHandler->updateViews();
    }
}