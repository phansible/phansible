<?php
/**
 * VarfileRenderer Test
 */

namespace App\Phansible\Renderer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Yaml;
use Twig\Environment;

class VarfileRendererTest extends TestCase
{
    /**
     * @var VarfileRenderer
     */
    private $model;

    public function setUp(): void
    {
        $this->model = new VarfileRenderer('common');
    }

    public function tearDown(): void
    {
        $this->model = null;
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::__construct)]
    public function testShouldConstruct()
    {
        $this->assertEquals('common', $this->model->getName());
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::loadDefaults)]
    public function testLoadDefaults()
    {
        $this->assertEquals('vars.yml.twig', $this->model->getTemplate());
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::setName)]
    #[covers(\App\Phansible\Renderer\VarfileRenderer::getName)]
    public function testShouldSetAndGetName()
    {
        $name = 'phansible';
        $this->model->setName($name);

        $this->assertEquals($name, $this->model->getName());
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::getTemplate)]
    #[covers(\App\Phansible\Renderer\VarfileRenderer::setTemplate)]
    public function testShouldSetAndGetTemplate()
    {
        $tpl = 'common.yml.twig';

        $this->model->setTemplate($tpl);

        $result = $this->model->getTemplate();

        $this->assertEquals($tpl, $result);
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::add)]
    #[covers(\App\Phansible\Renderer\VarfileRenderer::get)]
    public function testShouldAddAndGetVar()
    {
        $key   = 'doc_root';
        $value = '/vagrant/web';

        $this->model->add($key, $value);

        $this->assertEquals($value, $this->model->get($key));
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::setData)]
    #[covers(\App\Phansible\Renderer\VarfileRenderer::getData)]
    public function testShouldSetAndGetData()
    {
        $this->model->setData([
            'key' => 'value',
        ]);

        $data   = $this->model->getData();
        $parser = new Parser();

        $this->assertArrayHasKey('variables', $data);
        $this->assertTrue(is_array(
            $parser->parse($data['variables'], 1)
        ));

    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::add)]
    public function testShouldAddArrayValue()
    {
        $key   = 'packages';
        $value = ['git', 'curl'];

        $this->model->add($key, $value, false);

        $this->assertTrue(is_array($this->model->get('packages')));
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::getFilePath)]
    public function testGetFilePath()
    {
        $path = 'ansible/vars/common.yml';

        $this->assertEquals($path, $this->model->getFilePath());
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::renderFile)]
    public function testShouldRenderVarfile()
    {
        $twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['render'])
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('vars.yml.twig'), $this->model->getData())
            ->willReturn('');

        $this->model->renderFile($twig);
    }

    #[covers(\App\Phansible\Renderer\VarfileRenderer::addMultipleVars)]
    public function testShouldAddMultipleVars()
    {
        $vars = [
            'region' => 'brazil',
            'os'     => 'debian',
        ];

        $this->model->addMultipleVars($vars);

        $expected = [
            'variables' => Yaml::dump($vars),
            'name'      => 'common',
        ];

        $this->assertEquals($expected, $this->model->getData());
    }
}
