<?php

namespace App\Phansible;

use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{
    /**
     * @covers \App\Phansible\Application::__construct
     */
    public function testShouldVerifyInformationPassedByConstructor(): void
    {
        $app = new Application(__DIR__);

        $this->assertFalse($app['debug']);
    }
}
