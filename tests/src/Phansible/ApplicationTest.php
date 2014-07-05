<?php

namespace Phansible;

class ApplicationTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Phansible\Application::__construct
     */
    public function testShouldVerifyInformationPassedByConstructor()
    {
        $app = new Application(__DIR__);

        $this->assertTrue($app['debug']);
        $this->assertContains('/app/cache/config', $app['config.cache_dir']);
    }
}
