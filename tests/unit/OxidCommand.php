<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @link      http://www.oxid-esales.com
 * @package   tests
 * @copyright (C) OXID eSales AG 2003-2011
 * @version OXID eShop EE
 * @version   SVN: $Id: OxidCommand.php 25334 2010-01-22 07:14:37Z alfonsas $
 */

require_once 'PHPUnit/TextUI/Command.php';

class OxidCommand extends PHPUnit_TextUI_Command
{
     public function __construct()
     {
          $this->longOptions['dbreset='] = 'dbResetHandler';
     }

    /**
     * @param boolean $exit
     */
    public static function main($exit = true)
    {
        $command = new OxidCommand();
        $command->run($_SERVER['argv'], $exit);
    }

    /**
     * @param array   $argv
     * @param boolean $exit
     */
    public function run(array $argv, $exit = true)
    {
        parent::run($argv, false);
    }

    protected function dbResetHandler($value)
    {
       /* require_once 'unit/oxPrinter.php';
        require_once 'unit/dbMaintenance.php';
        $dbM = new dbMaintenance();
        $dbM->dumpDB();*/
    }

}
