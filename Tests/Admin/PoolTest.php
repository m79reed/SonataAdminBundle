<?php

/*
 * This file is part of the Sonata package.
 *
 * (c) Thomas Rabaix <thomas.rabaix@sonata-project.org>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sonata\AdminBundle\Tests\Admin;

use Sonata\AdminBundle\Admin\Pool;

class PoolTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Sonata\AdminBundle\Admin\Pool
     */
    private $pool = null;

    public function setUp()
    {
        $this->pool = new Pool($this->getContainer());
    }

    public function testGetGroups()
    {
        $this->pool->setAdminGroups(array(
            'adminGroup1' => array('sonata.user.admin.group1' => array())
        ));

        $expectedOutput = array(
            'adminGroup1' => array(
                'sonata.user.admin.group1' => 'adminUserClass'
            )
        );

        $this->assertEquals($expectedOutput, $this->pool->getGroups());
    }

    public function testGetDashboardGroups()
    {
        $this->pool->setAdminGroups(array(
            'adminGroup1' => array(
                'items' => array('itemKey' => 'sonata.user.admin.group1')
            )
        ));

        $expectedOutput = array(
            'adminGroup1' => array(
                'items' => array('itemKey' => 'adminUserClass')
            )
        );

        $this->assertEquals($expectedOutput, $this->pool->getDashboardGroups());
    }

    public function testGetAdminForClassWhenAdminClassIsNotSet()
    {
        $this->pool->setAdminClasses(array('someclass' => 'sonata.user.admin.group1'));
        $this->assertNull($this->pool->getAdminByClass('notexists'));
    }

    public function testGetAdminForClassWhenAdminClassIsSet()
    {
        $this->pool->setAdminClasses(array('someclass' => 'sonata.user.admin.group1'));
        $this->assertEquals('adminUserClass', $this->pool->getAdminByClass('someclass'));
    }

    public function testGetAdminByAdminCode()
    {
        $this->assertEquals('adminUserClass', $this->pool->getAdminByAdminCode('sonata.user.admin.group1'));
    }

    public function testGetAdminClasses()
    {
        $this->pool->setAdminClasses(array('someclass' => 'sonata.user.admin.group1'));
        $this->assertEquals(array('someclass' => 'sonata.user.admin.group1'), $this->pool->getAdminClasses());
    }

    public function testGetAdminGroups()
    {
        $this->pool->setAdminGroups(array('adminGroup1' => 'sonata.user.admin.group1'));
        $this->assertEquals(array('adminGroup1' => 'sonata.user.admin.group1'), $this->pool->getAdminGroups());
    }

    public function testGetAdminServiceIds()
    {
        $this->pool->setAdminServiceIds(array('sonata.user.admin.group1', 'sonata.user.admin.group2'));
        $this->assertEquals(array('sonata.user.admin.group1', 'sonata.user.admin.group2'), $this->pool->getAdminServiceIds());
    }

    /**
     * @return Symfony\Component\DependencyInjection\ContainerInterface - the mock of container interface
     */
    private function getContainer()
    {
        $containerMock = $this->getMock('Symfony\Component\DependencyInjection\ContainerInterface');
        $containerMock->expects($this->any())
            ->method('get')
            ->will($this->returnValue('adminUserClass'));

        return $containerMock;
    }
}