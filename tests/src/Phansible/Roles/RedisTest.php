<?php

namespace Phansible\Roles;

class RedisTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Phansible\Roles\Redis::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new Redis($app);

        $expected = [
            'install'   => 0,
            'port'      => 6379
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }
}
