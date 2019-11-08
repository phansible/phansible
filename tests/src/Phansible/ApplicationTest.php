<?php

namespace Phansible;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @covers \Phansible\Application::__construct
     */
    public function testShouldVerifyInformationPassedByConstructor(): void
    {
        $app = new Application(__DIR__);

        $this->assertFalse($app['debug']);
    }
}
