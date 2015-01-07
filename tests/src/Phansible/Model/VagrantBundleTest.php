<?php

namespace Phansible\Model;

use Phansible\Renderer\VagrantfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class VagrantBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VagrantBundle;
     */
    private $model;

    /**
     * @var Twig_Environment
     */
    private $twig;

    public function setUp()
    {
        $this->twig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $this->model = new VagrantBundle('path/to/ansible', $this->twig);
    }

    public function tearDown()
    {
        $this->model = null;
        $this->twig = null;
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getVagrantFile
     * @covers Phansible\Model\VagrantBundle::setVagrantFile
     */
    public function testShouldSetAndGetVagrantFile()
    {
        $vagrantFile = new VagrantfileRenderer();
        $this->model->setVagrantFile($vagrantFile);

        $this->assertEquals($vagrantFile, $this->model->getVagrantFile());
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getZipArchive
     */
    public function testShouldRetrieveZipArchive()
    {
        $result = $this->model->getZipArchive();

        $this->assertInstanceOf('\ZipArchive', $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::addRoleFiles
     * @covers Phansible\Model\VagrantBundle::includeBundleFiles
     */
    public function testShouldIncludeRole()
    {
        $model = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(array('includeBundleFiles'))
            ->getMock();

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('open'))
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
     * @covers Phansible\Model\VagrantBundle::includeBundleFiles
     */
    public function testDefaultIncludeBundleFiles()
    {
        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('addFile'))
            ->getMock();

        $mockedZip->expects($this->any())
            ->method('addFile')
            ->with(
                $this->stringContains('vars'),
                $this->stringContains('vars')
            );

        $ansiblePath = __DIR__ . '/../../../../src/Phansible/Resources/ansible';
        $this->model = new VagrantBundle($ansiblePath, $this->twig);

        $this->assertTrue(is_dir($ansiblePath));

        $this->model->includeBundleFiles($mockedZip, 'vars');
    }

    /**
     * @covers Phansible\Model\VagrantBundle::generateBundle
     */
    public function testShouldRetrieveZeroWhenGenerateBundleNotOpenFilePath()
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(array('getZipArchive'))
            ->getMock();

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('open'))
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->will($this->returnValue(false));

        $model->expects($this->once())
            ->method('getZipArchive')
            ->will($this->returnValue($mockedZip));

        $result = $model->generateBundle($filePath, ['nginx', 'php']);

        $this->assertEquals(0, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::generateBundle
     */
    public function testShouldRetrieveOneWhenGenerateBundle()
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(array('getZipArchive', 'renderFiles'))
            ->getMock();

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('open', 'addFile', 'close'))
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->will($this->returnValue(true));

        $mockedZip->expects($this->any())
            ->method('addFile')
            ->will($this->returnValue(true));

        $model->expects($this->once())
            ->method('getZipArchive')
            ->will($this->returnValue($mockedZip));

        $result = $model->generateBundle($filePath, ['nginx', 'php']);

        $this->assertEquals(1, $result);
    }

}
