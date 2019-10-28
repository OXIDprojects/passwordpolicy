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
 * @link          http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2019
 */

/**
 * Tests for "OxpsPasswordPolicy" class
 */
class Unit_Module_Controllers_OxpsPasswordPolicyTest extends OxidTestCase
{

    /**
     * `render` should return parent call results
     */
    public function testRender_returnParentSetsShopUrl()
    {
        $SUT = $this->getMock('OxpsPasswordPolicy', array('_oxpsPasswordPolicy_render_parent'));
        $SUT->expects($this->any())->method('_oxpsPasswordPolicy_render_parent')
            ->will($this->returnValue('render_parent'));

        $this->assertEquals('render_parent', $SUT->render());
        $this->assertArrayHasKey('sShopUrl', $SUT->getViewData());
    }
}
