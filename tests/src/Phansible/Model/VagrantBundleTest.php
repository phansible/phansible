<?php

namespace Phansible\Model;

use Phansible\Renderer\VagrantfileRenderer;
use PHPUnit\Framework\TestCase;
use Twig_Environment;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;

class VagrantBundleTest extends TestCase
{
    /**
     * @var VagrantBundle;
     */
    private $model;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function setUp(): void
    {
        $this->twig = $this->getMockBuilder(Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new VagrantBundle('path/to/ansible', $this->twig);
    }

    public function tearDown(): void
    {
        $this->model = null;
        $this->twig  = null;
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::__construct
     * @covers \Phansible\Model\VagrantBundle::getVagrantFile
     * @covers \Phansible\Model\VagrantBundle::setVagrantFile
     */
    public function testShouldSetAndGetVagrantFile(): void
    {
        $vagrantFile = new VagrantfileRenderer();
        $this->model->setVagrantFile($vagrantFile);

        $this->assertEquals($vagrantFile, $this->model->getVagrantFile());
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::__construct
     * @covers \Phansible\Model\VagrantBundle::getZipArchive
     */
    public function testShouldRetrieveZipArchive(): void
    {
        $result = $this->model->getZipArchive();

        $this->assertInstanceOf(\ZipArchive::class, $result);
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::addRoleFiles
     * @covers \Phansible\Model\VagrantBundle::includeBundleFiles
     */
    public function testShouldIncludeRole(): void
    {
        $model = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['includeBundleFiles'])
            ->getMock();

        $mockedZip = $this->getMockBuilder(\ZipArchive::class)
            ->onlyMethods(['open'])
            ->getMock();

        $model->expects($this->at(0))
            ->method('includeBundleFiles')
            ->with(
                $this->identicalTo($mockedZip),
                $this->equalTo('roles/nginx/defaults'),
                $this->equalTo('*.yml'),
                $this->equalTo('ansible/roles/nginx/defaults')
            );

        $model->expects($this->at(3))
            ->method('includeBundleFiles')
            ->with(
                $this->identicalTo($mockedZip),
                $this->equalTo('roles/nginx/templates'),
                $this->equalTo('*.tpl'),
                $this->equalTo('ansible/roles/nginx/templates')
            );

        $model->addRoleFiles('nginx', $mockedZip);
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::__construct
     * @covers \Phansible\Model\VagrantBundle::includeBundleFiles
     */
    public function testDefaultIncludeBundleFiles(): void
    {
        $mockedZip = $this->getMockBuilder(\ZipArchive::class)
            ->onlyMethods(['addFile'])
            ->getMock();

        $mockedZip->expects($this->any())
            ->method('addFile')
            ->with(
                $this->stringContains('vars'),
                $this->stringContains('vars')
            );

        $ansiblePath = __DIR__ . '/../../../../src/Phansible/Resources/ansible';
        $this->model = new VagrantBundle($ansiblePath, $this->twig);

        $this->assertDirectoryExists($ansiblePath);

        $this->model->includeBundleFiles($mockedZip, 'vars');
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::generateBundle
     */
    public function testShouldRetrieveZeroWhenGenerateBundleNotOpenFilePath(): void
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getZipArchive'])
            ->getMock();

        $mockedZip = $this->getMockBuilder(\ZipArchive::class)
            ->onlyMethods(['open'])
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->willReturn(false);

        $model->expects($this->once())
            ->method('getZipArchive')
            ->willReturn($mockedZip);

        $result = $model->generateBundle($filePath, ['nginx', 'php']);

        $this->assertEquals(0, $result);
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::generateBundle
     */
    public function testShouldRetrieveOneWhenGenerateBundle(): void
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getZipArchive', 'renderFiles'])
            ->getMock();

        $mockedZip = $this->getMockBuilder(\ZipArchive::class)
            ->onlyMethods(['open', 'addFile', 'close'])
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->willReturn(true);

        $mockedZip->expects($this->any())
            ->method('addFile')
            ->willReturn(true);

        $model->expects($this->once())
            ->method('getZipArchive')
            ->willReturn($mockedZip);

        $result = $model->generateBundle($filePath, ['nginx', 'php']);

        $this->assertEquals(1, $result);
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::__construct
     * @covers \Phansible\Model\VagrantBundle::getPlaybook
     * @covers \Phansible\Model\VagrantBundle::setPlaybook
     * @covers \Phansible\Model\VagrantBundle::addRenderer
     * @covers \Phansible\Model\VagrantBundle::getRenderer
     */
    public function testShouldSetAndGetPlaybook(): void
    {
        $playbook = $this->createMock(PlaybookRenderer::class);

        $this->model->setPlaybook($playbook);
        $this->assertSame($playbook, $this->model->getPlaybook());
    }

    /**
     * @covers \Phansible\Model\VagrantBundle::__construct
     * @covers \Phansible\Model\VagrantBundle::getVarsFile
     * @covers \Phansible\Model\VagrantBundle::setVarsFile
     * @covers \Phansible\Model\VagrantBundle::addRenderer
     * @covers \Phansible\Model\VagrantBundle::getRenderer
     */
    public function testShouldSetAndGetVarsFile(): void
    {
        $varsfile = $this->getMockBuilder(VarfileRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model->setVarsFile($varsfile);
        $this->assertSame($varsfile, $this->model->getVarsFile());
    }
}
