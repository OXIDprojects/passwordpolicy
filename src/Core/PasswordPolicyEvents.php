<?php


namespace OxidProfessionalServices\PasswordPolicy\Core;


class PasswordPolicyEvents
{
    public static function onActivate()
    {
        $query = "ALTER TABLE oxuser ADD OXTOTPSECRET varchar(255) NOT NULL;";
        try {
            \OxidEsales\Eshop\Core\DatabaseProvider::getDb()->execute($query);
        }catch (\Exception $exception)
        {
        }

    }
}