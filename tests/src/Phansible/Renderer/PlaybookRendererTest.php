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
        $varfile1 = new VarfileRenderer('common');
        $varfile2 = new VarfileRenderer('test');

        $this->model->addVarsFile($varfile1);

        $this->assertContains($varfile1, $this->model->getVarsFiles());

        $this->model->setVarsFiles([$varfile1, $varfile2]);

        $this->assertContainsOnlyInstancesOf('Phansible\Model\FileRendererInterface', $this->model->getVarsFiles());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::getVarsFilesList
     */
    public function testShouldGetVarsFilesList()
    {
        $varfile1 = new VarfileRenderer('common');
        $varfile2 = new VarfileRenderer('test');
        $this->model->setVarsFiles([$varfile1, $varfile2]);

        $list = $this->model->getVarsFilesList();
        $this->assertContains('vars/common.yml', $list);
        $this->assertContains('vars/test.yml', $list);
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::createVarsFile
     */
    public function testShouldCreateVarFile()
    {
        $data = [ 'key' => 'value' ];

        $this->model->createVarsFile('common', $data);

        $this->assertContainsOnlyInstancesOf('Phansible\Model\FileRendererInterface', $this->model->getVarsFiles());
        $this->assertContains('vars/common.yml', $this->model->getVarsFilesList());
    }

    /**
     * @covers Phansible\Renderer\PlaybookRenderer::createVarsFile
     */
    public function testShouldCreateVarFileAndSetTemplate()
    {
        $data = [ 'testkey' => 'testvalue' ];

        $this->model->createVarsFile('common', $data, 'test.twig');

        $varsfiles = $this->model->getVarsFiles();

        foreach ($varsfiles as $varfile) {
            $this->assertSame('testvalue', $varfile->get('testkey'));
            $this->assertSame('test.twig', $varfile->getTemplate());
        }
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
