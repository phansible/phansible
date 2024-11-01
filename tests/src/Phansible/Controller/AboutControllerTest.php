<?php

namespace App\Phansible\Controller;

use App\Phansible\Model\GithubAdapter;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use Twig\Environment;

class AboutControllerTest extends TestCase
{
    private $twig;
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->twig = $this->getTwigDouble();

        $container     = $this->getServiceContainerDouble();
        $githubAdapter = $this->getGithubAdapterDouble();

        $this->controller = new AboutController($githubAdapter);

        $this->controller->setContainer($container);
    }

    #[Covers(App\Phansible\Controller\AboutController::class)]
    public function testShouldRenderindexAction(): void
    {
        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('about.html.twig'),
                $this->arrayHasKey('contributors')
            );

        $this->controller->indexAction();
    }

    /**
     * @return MockObject
     */
    private function getTwigDouble(): MockObject
    {
        return $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();
    }

    /**
     * @return MockObject
     */
    private function getServiceContainerDouble(): MockObject
    {
        $container = $this->getMockBuilder(ContainerInterface::class)
            ->disableOriginalConstructor()
            ->onlyMethods([
                'get',
                'has',
            ])
            ->getMock();

        $container->expects($this->any())
            ->method('get')
            ->willReturnMap([
                ['twig', $this->twig],
            ]);

        $container->expects($this->any())
            ->method('has')
            ->with('twig')
            ->willReturn(true);

        return $container;
    }

    /**
     * @return MockObject
     */
    private function getGithubAdapterDouble(): MockObject
    {
        $githubAdapter = $this->getMockBuilder(GithubAdapter::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['get'])
            ->getMock();

        $githubAdapter->expects($this->any())
            ->method('get')
            ->with('contributors')
            ->willReturn(['contributors-data']);

        return $githubAdapter;
    }

    public function tearDown(): void
    {
        unset(
            $this->controller,
            $this->twig
        );

        parent::tearDown();
    }

}
