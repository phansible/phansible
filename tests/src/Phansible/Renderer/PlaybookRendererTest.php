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
     * @covers Phansible\Renderer\PlaybookRenderer::loadDefaults
     */
    public function testLoadDefaults()
    {
        $this->assertTrue(is_array($this->model->getVars()));
        $this->assertTrue(is_array($this->model->getVarsFiles()));
        $this->assertTrue(is_array($this->model->getRoles()));
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::getTemplate
     */
    public function testGetTemplate()
    {
        $path = 'playbook.yml.twig';

        $this->assertEquals($path, $this->model->getTemplate());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::getFilePath
     */
    public function testGetFilePath()
    {
        $path = 'ansible/playbook.yml';

        $this->assertEquals($path, $this->model->getFilePath());
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
     * @covers Phansible\Renderer\PlaybookRenderer::setVars
     * @covers Phansible\Renderer\PlaybookRenderer::getVars
     */
    public function testShouldSetAndGetVars()
    {
        $vars = [
            'web_server' => 'nginx',
            'doc_root'   => '/vagrant'
        ];

        $this->model->setVars($vars);

        $this->assertEquals($vars, $this->model->getVars());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::addVarsFile
     * @covers Phansible\Renderer\PlaybookRenderer::getVarsFiles
     * @covers Phansible\Renderer\PlaybookRenderer::setVarsFiles
     */
    public function testShouldAddAndGetVarsFile()
    {
        $var_file   = 'common.yml';

        $this->model->addVarsFile($var_file);

        $this->assertContains($var_file, $this->model->getVarsFiles());

        $this->model->setVarsFiles(['test01.yml', 'test02.yml']);

        $this->assertContains('test02.yml', $this->model->getVarsFiles());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::getRoles
     * @covers Phansible\Renderer\PlaybookRenderer::setRoles
     * @covers Phansible\Renderer\PlaybookRenderer::addRole
     */
    public function testShouldSetAndGetRoles()
    {
        $roles = [ 'nginx', 'php' ];

        $this->model->setRoles($roles);

        $this->assertEquals($roles, $this->model->getRoles());

        $this->model->addRole('init');

        $this->assertContains('init', $this->model->getRoles());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::getData
     */
    public function testGetData()
    {
        $data = $this->model->getData();

        $this->assertArrayHasKey('web_server', $data);
        $this->assertArrayHasKey('playbook_vars', $data);
        $this->assertArrayHasKey('playbook_files', $data);
        $this->assertArrayHasKey('playbook_roles', $data);
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
 