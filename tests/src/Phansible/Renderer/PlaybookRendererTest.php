<?php
/**
 * PlaybookRenderer Test
 */

namespace Phansible\Renderer;

class PlaybookRendererTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PlaybookRenderer;
     */
    private $model;

    public function setUp()
    {
        $this->model = new PlaybookRenderer();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::addVar
     * @covers Phansible\Renderer\PlaybookRenderer::getVar
     */
    public function testShouldAddAndGetVar()
    {
        $key   = 'web_server';
        $value = 'nginx';

        $this->model->addVar($key, $value);

        $this->assertEquals($value, $this->model->getVar($key));
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::addVarsFile
     * @covers Phansible\Renderer\PlaybookRenderer::getVarsFiles
     */
    public function testShouldAddAndGetVarsFile()
    {
        $var_file   = 'common.yml';

        $this->model->addVarsFile($var_file);

        $this->assertContains($var_file, $this->model->getVarsFiles());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::getRoles
     * @covers Phansible\Renderer\PlaybookRenderer::setRoles
     * @covers Phansible\Renderer\PlaybookRenderer::addRole
     */
    public function testShouldAddAndGetRoles()
    {
        $roles = [ 'nginx', 'php' ];

        $this->model->setRoles($roles);

        $this->assertEquals($roles, $this->model->getRoles());

        $this->model->addRole('init');

        $this->assertContains('init', $this->model->getRoles());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::renderFile
     */
    public function testShouldRenderPlaybook()
    {
        $this->model->setRoles(['nginx', 'php5-fpm']);

        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('playbook.yml.twig'), $this->model->getData());

        $result = $this->model->renderFile($twig);

    }
}
 