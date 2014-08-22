<?php
/**
 * VarfileRenderer Test
 */

namespace Phansible\Renderer;


class VarfileRendererTest extends \PHPUnit_Framework_TestCase
{
    private $model;

    public function setUp()
    {
        $this->model = new VarfileRenderer('common');
    }

    public function tearDown()
    {
        $this->model = null;
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::__construct
     */
    public function testShouldConstruct()
    {
        $this->assertEquals('common', $this->model->getName());
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::loadDefaults
     */
    public function testLoadDefaults()
    {
        $this->assertEquals('vars.yml.twig', $this->model->getTemplate());
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::setName
     * @covers Phansible\Renderer\VarfileRenderer::getName
     */
    public function testShouldSetAndGetName()
    {
        $name = 'phansible';
        $this->model->setName($name);

        $this->assertEquals($name, $this->model->getName());
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::getTemplate
     * @covers Phansible\Renderer\VarfileRenderer::setTemplate
     */
    public function testShouldSetAndGetTemplate()
    {
        $tpl = 'common.yml.twig';

        $this->model->setTemplate($tpl);

        $result = $this->model->getTemplate();

        $this->assertEquals($tpl, $result);
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::add
     * @covers Phansible\Renderer\VarfileRenderer::get
     */
    public function testShouldAddAndGetVar()
    {
        $key   = 'doc_root';
        $value = '/vagrant/web';

        $this->model->add($key, $value);

        $this->assertEquals($value, $this->model->get($key));
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::setData
     * @covers Phansible\Renderer\VarfileRenderer::getData
     */
    public function testShouldSetAndGetData()
    {
        $this->model->setData([
            'key' => 'value'
        ]);

        $data = $this->model->getData();

        $this->assertArrayHasKey('variables', $data);
        $this->assertArrayHasKey('key', $data['variables']);
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::getFilePath
     */
    public function testGetFilePath()
    {
        $path = 'ansible/vars/common.yml';

        $this->assertEquals($path, $this->model->getFilePath());
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::getData
     */
    public function testGetData()
    {
        $this->model->add('test', 'test');

        $data = $this->model->getData();

        $this->assertArrayHasKey('variables', $data);
        $this->assertArrayHasKey('test', $data['variables']);
    }

    /**
     * @covers Phansible\Renderer\VarfileRenderer::renderFile
     */
    public function testShouldRenderVarfile()
    {
        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('vars.yml.twig'), $this->model->getData());

        $result = $this->model->renderFile($twig);

    }
}
 