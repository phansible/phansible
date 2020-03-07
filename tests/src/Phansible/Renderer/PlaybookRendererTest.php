<?php
/**
 * PlaybookRenderer Test
 */

namespace App\Phansible\Renderer;

use PHPUnit\Framework\TestCase;
use Twig\Environment;

class PlaybookRendererTest extends TestCase
{
    /**
     * @var PlaybookRenderer;
     */
    private $model;

    public function setUp(): void
    {
        $this->model = new PlaybookRenderer();
    }

    public function tearDown(): void
    {
        $this->model = null;
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::getTemplate
     */
    public function testGetTemplate(): void
    {
        $path = 'playbook.yml.twig';

        $this->assertEquals($path, $this->model->getTemplate());
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::getFilePath
     */
    public function testGetFilePath(): void
    {
        $path = 'ansible/playbook.yml';

        $this->assertEquals($path, $this->model->getFilePath());
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::getRoles
     * @covers \App\Phansible\Renderer\PlaybookRenderer::setRoles
     * @covers \App\Phansible\Renderer\PlaybookRenderer::addRole
     */
    public function testShouldSetAndGetRoles(): void
    {
        $roles = ['nginx', 'php'];

        $this->model->setRoles($roles);

        $this->assertEquals($roles, $this->model->getRoles());

        $this->model->addRole('init');

        $this->assertContains('init', $this->model->getRoles());
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::getData
     * @covers \App\Phansible\Renderer\PlaybookRenderer::setVarsFilename
     */
    public function testGetData(): void
    {
        $this->model->setVarsFilename('test.yml');
        $data = $this->model->getData();


        $this->assertArrayHasKey('varsfile', $data);
        $this->assertArrayHasKey('roles', $data);
        $this->assertEquals('test.yml', $data['varsfile']);
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::renderFile
     */
    public function testShouldRenderPlaybook(): void
    {
        $this->model->setRoles(['nginx', 'php5-fpm']);

        $twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('playbook.yml.twig'), $this->model->getData())
            ->willReturn('');

        $this->model->renderFile($twig);
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::hasRole
     */
    public function testShouldRetrieveFalseIfRoleNotExists(): void
    {
        $this->assertFalse($this->model->hasRole('something'));
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::hasRole
     */
    public function testShouldRetrieveTrueIfRoleExists(): void
    {
        $this->model->addRole('mysql');
        $this->assertTrue($this->model->hasRole('mysql'));
    }

    /**
     * @covers \App\Phansible\Renderer\PlaybookRenderer::loadDefaults
     */
    public function testShouldLoadDefaults(): void
    {
        $this->model->loadDefaults();

        $this->assertEquals('playbook.yml.twig', $this->model->getTemplate());
        $this->assertEquals('ansible/playbook.yml', $this->model->getFilePath());
    }
}
