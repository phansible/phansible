<?php

namespace Phansible\Model;

use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VagrantfileRenderer;

class VagrantBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VagrantBundle;
     */
    private $model;

    /**
     * @var PlaybookRenderer
     */
    private $playbook;

    public function setUp()
    {
        $this->model    = new VagrantBundle();
        $this->playbook = new PlaybookRenderer();
    }

    public function tearDown()
    {
        $this->model = null;
    }

    /**
     * @covers Phansible\Model\VagrantBundle::__construct
     */
    public function testShouldConstructBundle()
    {
        $this->assertInstanceOf('Twig_Environment', $this->model->getTwig());
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getTwig
     * @covers Phansible\Model\VagrantBundle::setTwig
     */
    public function testShouldSetAndGetTwig()
    {
        $twig = "twig";

        $this->model->setTwig($twig);

        $result = $this->model->getTwig();

        $this->assertEquals($twig, $result);
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
     * @covers Phansible\Model\VagrantBundle::getRolesPath
     */
    public function testShoulRetrieveDefaultRolesPath()
    {
        $expected = '/../Resources/ansible/roles';
        $result   = $this->model->getRolesPath();

        $expected = strpos($result, $expected) !== false;

        $this->assertTrue($expected);
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
            ->setMethods(array('open', 'addFromString', 'close'))
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->will($this->returnValue(true));

        $model->expects($this->once())
            ->method('getZipArchive')
            ->will($this->returnValue($mockedZip));

        $result = $model->generateBundle($filePath, ['nginx', 'php']);

        $this->assertEquals(1, $result);
    }

}
