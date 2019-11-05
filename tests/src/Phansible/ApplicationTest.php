<?php

namespace Phansible;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @covers \Phansible\Application::__construct
     */
    public function testShouldVerifyInformationPassedByConstructor()
    {
        $app = new Application(__DIR__);

        $this->assertFalse($app['debug']);
        $this->assertStringContainsString('/app/cache/config', $app['config.cache_dir']);
    }
}
