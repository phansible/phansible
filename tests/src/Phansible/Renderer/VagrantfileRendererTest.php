<?php
/**
 * Vagrantfile Renderer Test
 */

namespace Phansible\Renderer;

use PHPUnit\Framework\TestCase;

class VagrantfileRendererTest extends TestCase
{
    /**
     * @var VagrantfileRenderer
     */
    private $model;

    public function setUp(): void
    {
        $this->model = new VagrantfileRenderer();
    }

    public function tearDown(): void
    {
        $this->model = null;
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::loadDefaults
     */
    public function testLoadDefaults(): void
    {
        $this->assertEquals(512, $this->model->getMemory());
        $this->assertEquals('default', $this->model->getName());
        $this->assertEquals('ubuntu/trusty64', $this->model->getBoxName());
        $this->assertEquals('', $this->model->getBoxUrl());
        $this->assertEquals('192.168.33.99', $this->model->getIpAddress());
        $this->assertEquals('./', $this->model->getSyncedFolder());
        $this->assertEquals('nfs', $this->model->getSyncedType());
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getTemplate
     */
    public function testGetTemplate(): void
    {
        $path = 'Vagrantfile.twig';

        $this->assertEquals($path, $this->model->getTemplate());
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getFilePath
     */
    public function testGetFilePath(): void
    {
        $path = 'Vagrantfile';

        $this->assertEquals($path, $this->model->getFilePath());
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getMemory
     * @covers \Phansible\Renderer\VagrantfileRenderer::setMemory
     */
    public function testShouldSetAndGetMemory(): void
    {
        $memory = 512;

        $this->model->setMemory($memory);

        $result = $this->model->getMemory();

        $this->assertEquals($memory, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getName
     * @covers \Phansible\Renderer\VagrantfileRenderer::setName
     */
    public function testShouldSetAndGetVmName(): void
    {
        $vmName = 'phansible';

        $this->model->setName($vmName);

        $result = $this->model->getName();

        $this->assertEquals($vmName, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getBoxName
     * @covers \Phansible\Renderer\VagrantfileRenderer::setBoxName
     */
    public function testShouldSetAndGetBox(): void
    {
        $box = 'precise64';

        $this->model->setBoxName($box);

        $result = $this->model->getBoxName();

        $this->assertEquals($box, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getBoxUrl
     * @covers \Phansible\Renderer\VagrantfileRenderer::setBoxUrl
     */
    public function testShouldSetAndGetBoxUrl(): void
    {
        $boxUrl = 'http://files.vagrantup.com/precise64.box';

        $this->model->setBoxUrl($boxUrl);

        $result = $this->model->getBoxUrl();

        $this->assertEquals($boxUrl, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getIpAddress
     * @covers \Phansible\Renderer\VagrantfileRenderer::setIpAddress
     */
    public function testShouldSetAndGetIpAddress(): void
    {
        $ipAddress = '192.168.100.100';

        $this->model->setIpAddress($ipAddress);

        $result = $this->model->getIpAddress();

        $this->assertEquals($ipAddress, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getSyncedFolder
     * @covers \Phansible\Renderer\VagrantfileRenderer::setSyncedFolder
     */
    public function testShouldSetAndGetSyncedFolder(): void
    {
        $syncedFolder = './';

        $this->model->setSyncedFolder($syncedFolder);

        $result = $this->model->getSyncedFolder();

        $this->assertEquals($syncedFolder, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getSyncedType
     * @covers \Phansible\Renderer\VagrantfileRenderer::setSyncedType
     */
    public function testShouldSetAndGetSyncedFolderType(): void
    {
        $syncedType = 'nfs';

        $this->model->setSyncedType($syncedType);

        $result = $this->model->getSyncedType();

        $this->assertEquals($syncedType, $result);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::getData
     */
    public function testGetData(): void
    {
        $data = $this->model->getData();

        $this->assertArrayHasKey('vmName', $data);
        $this->assertArrayHasKey('memory', $data);
        $this->assertArrayHasKey('boxUrl', $data);
        $this->assertArrayHasKey('boxName', $data);
        $this->assertArrayHasKey('ipAddress', $data);
        $this->assertArrayHasKey('syncedFolder', $data);
    }

    /**
     * @covers \Phansible\Renderer\VagrantfileRenderer::renderFile
     */
    public function testShouldRenderVagrantfile(): void
    {
        $this->model->setName('phansible');

        $twig = $this->getMockBuilder(\Twig_Environment::class)
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
