<?php

namespace App\Phansible\Provider;

use App\Phansible\Model\GithubAdapter;
use PHPUnit\Framework\TestCase;

class GithubProviderStaticFactoryTest extends TestCase
{
    /**
     * @var GithubProviderStaticFactory
     */
    private $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = GithubProviderStaticFactory::class;
    }

    public function testItShouldReturnAGithubAdapter(): void
    {
        $githubAdapter = $this->factory::create();

        $this->assertInstanceOf(GithubAdapter::class, $githubAdapter);
    }

    public function tearDown(): void
    {
        unset(
            $this->factory,
        );

        parent::tearDown();
    }
}
