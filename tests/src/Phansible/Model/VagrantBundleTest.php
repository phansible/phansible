<?php

namespace App\Phansible\Model;

use App\Phansible\Renderer\PlaybookRenderer;
use App\Phansible\Renderer\VagrantfileRenderer;
use App\Phansible\Renderer\VarfileRenderer;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use ZipArchive;

class VagrantBundleTest extends TestCase
{
    /**
     * @var VagrantBundle;
     */
    private $model;

    private $ansiblePath = __DIR__ . '/../../../../src/Phansible/Resources/ansible';

    /**
     * @var Environment
     */
    private $twig;

    public function setUp(): void
    {
        $this->twig = $this->getMockBuilder(Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new VagrantBundle($this->ansiblePath, $this->twig);

    }

    public function tearDown(): void
    {
        $this->model = null;
        $this->twig  = null;
    }

    #[covers(App\Phansible\Model\VagrantBundle::__construct)]
    #[covers(App\Phansible\Model\VagrantBundle::getVagrantFile)]
    #[covers(App\Phansible\Model\VagrantBundle::setVagrantFile)]
    public function testShouldSetAndGetVagrantFile(): void
    {
        $vagrantFile = new VagrantfileRenderer();
        $this->model->setVagrantFile($vagrantFile);

        $this->assertEquals($vagrantFile, $this->model->getVagrantFile());
    }

    #[covers(App\Phansible\Model\VagrantBundle::__construct)]
    #[covers(App\Phansible\Model\VagrantBundle::getZipArchive)]
    public function testShouldRetrieveZipArchive(): void
    {
        $result = $this->model->getZipArchive();

        $this->assertInstanceOf(ZipArchive::class, $result);
    }

    // #[covers(App\Phansible\Model\VagrantBundle::addRoleFiles)]
    // #[covers(App\Phansible\Model\VagrantBundle::includeBundleFiles)]
    // public function testShouldIncludeRole(): void
    // {
    //     $model = $this->getMockBuilder(VagrantBundle::class)
    //         ->disableOriginalConstructor()
    //         ->onlyMethods(['includeBundleFiles'])
    //         ->getMock();

    //     $mockedZip = $this->getMockBuilder(ZipArchive::class)
    //         ->onlyMethods(['open'])
    //         ->getMock();

    //     $model->method('includeBundleFiles')
    //         ->willReturnOnConsecutiveCalls(
    //             [
    //                 $this->identicalTo($mockedZip),
    //                 $this->equalTo('roles/nginx/defaults'),
    //                 $this->equalTo('*.yml'),
    //                 $this->equalTo('ansible/roles/nginx/defaults'),
    //             ],
    //             [
    //                 $this->identicalTo($mockedZip),
    //                 $this->equalTo('roles/nginx/tasks'),
    //                 $this->equalTo('*.yml'),
    //                 $this->equalTo('ansible/roles/nginx/tasks'),
    //             ],
    //             [
    //                 $this->identicalTo($mockedZip),
    //                 $this->equalTo('roles/nginx/handlers'),
    //                 $this->equalTo('*.yml'),
    //                 $this->equalTo('ansible/roles/nginx/handlers'),
    //             ],
    //             [
    //                 $this->identicalTo($mockedZip),
    //                 $this->equalTo('roles/nginx/templates'),
    //                 $this->equalTo('*.tpl'),
    //                 $this->equalTo('ansible/roles/nginx/templates'),
    //             ]
    //         );

    //     $model->addRoleFiles('nginx', $mockedZip);
    // }

    #[covers(App\Phansible\Model\VagrantBundle::__construct)]
    #[covers(App\Phansible\Model\VagrantBundle::includeBundleFiles)]
    public function testDefaultIncludeBundleFiles(): void
    {
        $mockedZip = $this->getMockBuilder(ZipArchive::class)
            ->onlyMethods(['addFile'])
            ->getMock();

        $mockedZip->expects($this->any())
            ->method('addFile')
            ->with(
                $this->stringContains('vars'),
                $this->stringContains('vars')
            );


        $this->assertDirectoryExists($this->ansiblePath);

        $this->model->includeBundleFiles($mockedZip, 'vars');
    }

    #[covers(App\Phansible\Model\VagrantBundle::generateBundle)]
    public function testShouldRetrieveZeroWhenGenerateBundleNotOpenFilePath(): void
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getZipArchive'])
            ->getMock();

        $mockedZip = $this->getMockBuilder(ZipArchive::class)
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

    #[covers(App\Phansible\Model\VagrantBundle::generateBundle)]
    public function testShouldRetrieveOneWhenGenerateBundle(): void
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder(VagrantBundle::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['getZipArchive', 'renderFiles'])
            ->getMock();

        $mockedZip = $this->getMockBuilder(ZipArchive::class)
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

    #[covers(App\Phansible\Model\VagrantBundle::__construct)]
    #[covers(App\Phansible\Model\VagrantBundle::getPlaybook)]
    #[covers(App\Phansible\Model\VagrantBundle::setPlaybook)]
    #[covers(App\Phansible\Model\VagrantBundle::addRenderer)]
    #[covers(App\Phansible\Model\VagrantBundle::getRenderer)]
    public function testShouldSetAndGetPlaybook(): void
    {
        $playbook = $this->createMock(PlaybookRenderer::class);

        $this->model->setPlaybook($playbook);
        $this->assertSame($playbook, $this->model->getPlaybook());
    }

    #[covers(App\Phansible\Model\VagrantBundle::__construct)]
    #[covers(App\Phansible\Model\VagrantBundle::getVarsFile)]
    #[covers(App\Phansible\Model\VagrantBundle::setVarsFile)]
    #[covers(App\Phansible\Model\VagrantBundle::addRenderer)]
    #[covers(App\Phansible\Model\VagrantBundle::getRenderer)]
    public function testShouldSetAndGetVarsFile(): void
    {
        $varsfile = $this->getMockBuilder(VarfileRenderer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->model->setVarsFile($varsfile);
        $this->assertSame($varsfile, $this->model->getVarsFile());
    }
}
