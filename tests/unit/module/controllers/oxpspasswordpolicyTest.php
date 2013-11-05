<?php
/**
 * This Software is the property of OXID eSales and is protected
 * by copyright law - it is NOT Freeware.
 *
 * Any unauthorized use of this software without a valid license key
 * is a violation of the license agreement and will be prosecuted by
 * civil and criminal law.
 *
 * @category  tests
 * @package   passwordpolicy
 * @author    OXID Professional services
 * @link      http://www.oxid-esales.com
 * @copyright (C) OXID eSales AG 2003-2012
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
