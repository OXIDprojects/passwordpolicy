<?php


namespace OxidProfessionalServices\PasswordPolicy\Core;


use OxidEsales\Eshop\Core\DbMetaDataHandler;

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

    }

    /**
     * Regenerate views for changed tables
     */
    protected static function regenerateViews()
    {
        $oDbMetaDataHandler = oxNew(DbMetaDataHandler::class );
        $oDbMetaDataHandler->updateViews();
    }
}