<?php


namespace OxidProfessionalServices\PasswordPolicy\Core;


use OxidEsales\Eshop\Application\Model\User;
use OxidEsales\Eshop\Core\DatabaseProvider;
use OxidEsales\Eshop\Core\DbMetaDataHandler;
use OxidEsales\Eshop\Core\Exception\UserException;
use OxidEsales\Eshop\Core\ViewConfig;
use OxidEsales\EshopCommunity\Core\Exception\FileException;

class PasswordPolicyEvents
{
    /**
     * @throws UserException
     * @throws FileException
     */
    public static function onActivate()
    {
        $user = oxNew(User::class);
        if(!(in_array('oxpstotpsecret',$user->getFieldNames()) && in_array('oxpsbackupcode',$user->getFieldNames()))) {
            $query = "ALTER TABLE oxuser ADD OXPSTOTPSECRET varchar(255) NOT NULL,
                                     ADD OXPSBACKUPCODE varchar(255) NOT NULL;";
            try {
                DatabaseProvider::getDb()->execute($query);
                self::regenerateViews();
            } catch (\Exception $exception) {
                throw new UserException("Ein Fehler ist bei der Erzeugung der neuen Datenbankspalten aufgetreten: \n" . $exception);
            }
        }
            $viewConf = oxNew(ViewConfig::class);
            $modulePath = $viewConf->getModulePath('oxpspasswordpolicy');
            $filePath = $modulePath . 'twofactor.config.inc.php';
            if(!file_exists($filePath))
            {
                $key = self::generateKey();
                file_put_contents($filePath, '<?php 
$this->key=' . "\"$key\";");
            }
    }


    protected static function generateKey(): string
    {
        $key = random_bytes(32);
        $hashedKey = base64_encode($key);
        return $hashedKey;
    }
    protected static function regenerateViews()
    {
        $oDbMetaDataHandler = oxNew(DbMetaDataHandler::class );
        $oDbMetaDataHandler->updateViews();
    }
}