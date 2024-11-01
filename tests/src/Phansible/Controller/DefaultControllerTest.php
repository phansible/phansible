<?php

namespace App\Phansible\Controller;

use App\Phansible\RolesManager;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;
use SplFileObject;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Twig\Environment;

class DefaultControllerTest extends TestCase
{
    private $twig;
    private $controller;

    public function setUp(): void
    {
        parent::setUp();

        $this->twig = $this->getTwigDouble();

        $container    = $this->getServiceContainerDouble();
        $rolesManager = $this->getRolesManagerDouble();

        $this->controller = new DefaultController($rolesManager);

        $this->controller->setContainer($container);
    }

    #[Covers(App\Phansible\Controller\DefaultController::indexAction)]
    public function testShouldRenderIndexAction(): void
    {
        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('index.html.twig'),
                $this->arrayHasKey('config')
            );

        $this->controller->indexAction();
    }

    #[Covers(App\Phansible\Controller\DefaultController::docsAction)]
    #[expectException(Symfony\Component\HttpKernel\Exception\NotFoundHttpException)]
    public function testShouldThrowExceptionWhenDocFileNotExists(): void
    {
        $doc = '';
        $this->expectException(NotFoundHttpException::class);
        $this->controller->docsAction($doc);
    }

    #[Covers(App\Phansible\Controller\DefaultController::docsAction)]
    public function testShouldRenderDocsActionWhenFileExists(): void
    {
        $this->twig->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('docs.html.twig'),
                $this->callback(function ($param) {
                    return array_key_exists('content', $param) && strpos($param['content'], 'ansible');
                })
            );

        $docFile = new SplFileObject('/tmp/vagrant.md', 'w+');
        $docFile->fwrite('Phansible');

        $doc = 'vagrant';

        $this->controller->docsAction($doc);

        unlink($docFile->getPathname());
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
    private function getRolesManagerDouble(): MockObject
    {
        return $this->getMockBuilder(RolesManager::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['register'])
            ->getMock();
    }

    public function tearDown(): void
    {
        unset(
            $this->controller,
            $this->container,
            $this->twig,
        );

        parent::tearDown();
    }
}

