<?php

namespace Phansible\Roles;

class RoleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @use Phansible\Roles\BaseRole::getInitialValues
     */
    public function testInitialValuesShouldReturnArray()
    {
        $role = $this->getMockBuilder('\Phansible\BaseRole')
            ->disableOriginalConstructor()
            ->getMockForAbstractClass();

        $role->expects($this->once())
            ->method('getInitialValues')
            ->will($this->returnValue([]));

        $this->assertInternalType('array', $role->getInitialValues());
    }
}
