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
     * @covers Phansible\Renderer\VarfileRenderer::setData
     * @covers Phansible\Renderer\VarfileRenderer::getData
     */
    public function testShouldSetAndGetVar()
    {
        $key   = 'doc_root';
        $value = '/vagrant/web';

        $this->model->add($key, $value);

        $this->assertEquals($value, $this->model->get($key));

        $this->model->setData([
            $key => $value
        ]);

        $this->assertEquals($value, $this->model->get($key));
        $this->assertArrayHasKey('variables', $this->model->getData());
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
 