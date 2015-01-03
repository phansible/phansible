<?php
/**
 * Abstract FileRenderer Test
 */

namespace Phansible\Renderer;

class TemplateRendererTest extends \PHPUnit_Framework_TestCase
{
    private $model;

    public function setUp()
    {
        $this->model = new TemplateRenderer();
        $this->model->setTemplate('Vagrantfile.twig');
        $this->model->setData(['key' => 'value']);
    }

    public function tearDown()
    {
        $this->model = null;
    }

    public function testConstructorShouldCallMethod()
    {
        $className = 'Phansible\Renderer\TemplateRenderer';

        $mock = $this->getMockBuilder($className)
            ->disableOriginalConstructor()
            ->getMock();

        $mock->expects($this->once())
            ->method('loadDefaults')
            ->will(
                $this->returnValue(null)
            );

        $reflectedClass = new \ReflectionClass($className);
        $constructor = $reflectedClass->getConstructor();
        $constructor->invoke($mock);
    }

    /**
     * @covers Phansible\Renderer\TemplateRenderer::add
     */
    public function testShouldAddArrayValue()
    {
        $key   = 'packages';
        $value = ['git', 'curl'];

        $this->model->add($key, $value);

        $this->assertTrue(is_array($this->model->get('packages')));
    }

    /**
     * @covers Phansible\Renderer\TemplateRenderer::setFilePath
     * @covers Phansible\Renderer\TemplateRenderer::getFilePath
     */
    public function testShouldSetAndGetFilePath()
    {
        $path = 'ansible/vars/common.yml';

        $this->model->setFilePath($path);

        $this->assertEquals($path, $this->model->getFilePath());
    }

    /**
     * @covers Phansible\Renderer\TemplateRenderer::getData
     */
    public function testGetData()
    {
        $this->model->add('test', 'test');

        $data = $this->model->getData();

        $this->assertArrayHasKey('test', $data);
    }

    /**
     * @covers Phansible\Renderer\TemplateRenderer::renderFile
     */
    public function testRenderFile()
    {
        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('Vagrantfile.twig'), $this->model->getData());

        $this->model->renderFile($twig);
    }
}
