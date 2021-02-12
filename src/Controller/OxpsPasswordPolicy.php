<?php

/**
 * This file is part of OXID Professional Services Password Policy module.
 *
 * OXID Professional Services Password Policy module is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * OXID Professional Services Password Policy module is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with OXID Professional Services Password Policy module.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @author        OXID Professional services
 * @link          https://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2021
 */

namespace OxidProfessionalServices\PasswordPolicy\Controller;

use OxidEsales\Eshop\Core\Registry;
use OxidProfessionalServices\PasswordPolicy\Core\PasswordPolicyModule;

/**
 * Password policy main controller
 */
class OxpsPasswordPolicy extends oxUBase
{

    /**
     * @var string Template name.
     */
    //phpcs:ignore
    protected $_sThisTemplate = "passwordpolicyaccountblocked.tpl";


    /**
     * Overridden render method.
     * Adds shop URL to view data.
     *
     * @return mixed
     */
    public function render()
    {
        $oModule = oxNew(PasswordPolicyModule::class);

        $this->_aViewData['sShopUrl'] = Registry::getConfig()->getShopUrl();
        $this->_aViewData['blAllowUnblock'] = (bool)$oModule->getModuleSetting('blAllowUnblock');

        // Parent render call
        return $this->oxpsPasswordPolicyRenderParent();
    }


    /**
     * Parent `render` call. Method required for mocking.
     *
     * @return mixed
     */
    protected function oxpsPasswordPolicyRenderParent()
    {
        // @codeCoverageIgnoreStart
        return parent::render();
        // @codeCoverageIgnoreEnd
    }
}
