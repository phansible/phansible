<?php
/**
 * Abstract FileRenderer Test
 */

namespace App\Phansible\Renderer;

use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Twig\Environment;

class TemplateRendererTest extends TestCase
{
    private $model;

    public function setUp(): void
    {
        $this->model = new TemplateRenderer();
        $this->model->setTemplate('Vagrantfile.twig');
        $this->model->setData(['key' => 'value']);
    }

    public function tearDown(): void
    {
        $this->model = null;
    }

    public function testConstructorShouldCallMethod(): void
    {
        $className = TemplateRenderer::class;

        $mock = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('loadDefaults');

        $reflectedClass = new ReflectionClass($className);
        $constructor    = $reflectedClass->getConstructor();
        $constructor->invoke($mock);
    }

    #[covers(\App\Phansible\Renderer\TemplateRenderer::add)]
    public function testShouldAddArrayValue(): void
    {
        $key   = 'packages';
        $value = ['git', 'curl'];

        $this->model->add($key, $value);

        $this->assertIsArray($this->model->get('packages'));
    }

    #[covers(\App\Phansible\Renderer\TemplateRenderer::setFilePath)]
    #[covers(\App\Phansible\Renderer\TemplateRenderer::getFilePath)]
    public function testShouldSetAndGetFilePath(): void
    {
        $path = 'ansible/vars/common.yml';

        $this->model->setFilePath($path);

        $this->assertEquals($path, $this->model->getFilePath());
    }

    #[covers(\App\Phansible\Renderer\TemplateRenderer::getData)]
    public function testGetData(): void
    {
        $this->model->add('test', 'test');

        $data = $this->model->getData();

        $this->assertArrayHasKey('test', $data);
    }

    #[covers(\App\Phansible\Renderer\TemplateRenderer::renderFile)]
    public function testRenderFile(): void
    {
        $twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('Vagrantfile.twig'), $this->model->getData())
            ->willReturn('');

        $this->model->renderFile($twig);
    }
}
