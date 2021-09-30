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
        if (!(in_array('oxpstotpsecret', $user->getFieldNames()) && in_array('oxpsbackupcode', $user->getFieldNames()))) {
            $query = "ALTER TABLE oxuser ADD OXPSTOTPSECRET varchar(255) NOT NULL,
                                     ADD OXPSBACKUPCODE varchar(255) NOT NULL;";
            try {
                DatabaseProvider::getDb()->execute($query);
                self::regenerateViews();
            } catch (\Exception $exception) {
                throw oxNew(UserException::class, "Ein Fehler ist bei der Erzeugung der neuen Datenbankspalten aufgetreten: \n" . $exception);
            }
            self::clearTmp();
        }

        $viewConf = oxNew(ViewConfig::class);
        $modulePath = $viewConf->getModulePath('oxpspasswordpolicy');
        $filePath = $modulePath . 'twofactor.config.inc.php';
        if (!file_exists($filePath)) {
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
        $oDbMetaDataHandler = oxNew(DbMetaDataHandler::class);
        $oDbMetaDataHandler->updateViews();
    }

    public static function clearTmp($clearFolderPath = '')
    {
        $folderPath = self::_getFolderToClear($clearFolderPath);
        $directoryHandler = opendir($folderPath);

        if (!empty($directoryHandler)) {
            while (false !== ($fileName = readdir($directoryHandler))) {
                $filePath = $folderPath . DIRECTORY_SEPARATOR . $fileName;
                self::_clear($fileName, $filePath);
            }

            closedir($directoryHandler);
        }

        return true;
    }

    protected static function _getFolderToClear($clearFolderPath = '')
    {
        $templateFolderPath = (string)\OxidEsales\Eshop\Core\Registry::getConfig()->getConfigParam('sCompileDir');

        if (!empty($clearFolderPath) and (strpos($clearFolderPath, $templateFolderPath) !== false)) {
            $folderPath = $clearFolderPath;
        } else {
            $folderPath = $templateFolderPath;
        }

        return $folderPath;
    }

    /**
     * Check if resource could be deleted, then delete it's a file or
     * call recursive folder deletion if it's a directory.
     *
     * @param string $fileName
     * @param string $filePath
     */
    protected static function _clear($fileName, $filePath)
    {
        if (!in_array($fileName, ['.', '..', '.gitkeep', '.htaccess'])) {
            if (is_file($filePath)) {
                @unlink($filePath);
            } else {
                self::clearTmp($filePath);
            }
        }
    }
}