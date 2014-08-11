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
        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $this->model->setTwig($twig);

        $result = $this->model->getTwig();

        $this->assertEquals($twig, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::addRenderer
     * @covers Phansible\Model\VagrantBundle::getRenderers
     * @covers Phansible\Model\VagrantBundle::setRenderers
     */
    public function testShouldSetAndGetRenderer()
    {
        $renderer = $this->getMockBuilder('Phansible\Renderer\VagrantfileRenderer')
            ->getMock();

        $this->model->addRenderer($renderer);

        $this->assertContains($renderer, $this->model->getRenderers());

        $renderer2 = $this->getMockBuilder('Phansible\Renderer\PlaybookRenderer')
            ->getMock();

        $this->model->setRenderers([$renderer, $renderer2]);

        $this->assertContainsOnlyInstancesOf('Phansible\Model\FileRenderer', $this->model->getRenderers());
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
            ->with($this->identicalTo($mockedZip),
                $this->equalTo('roles/nginx/tasks'),
                $this->equalTo('*.yml'),
                $this->equalTo('ansible/roles/nginx/tasks')
            );

        $model->expects($this->at(2))
            ->method('includeBundleFiles')
            ->with($this->identicalTo($mockedZip),
                $this->equalTo('roles/nginx/templates'),
                $this->equalTo('*.tpl'),
                $this->equalTo('ansible/roles/nginx/templates')
            );

        $model->addRoleFiles('nginx', $mockedZip);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::renderFiles
     */
    public function testShouldRenderFile()
    {
        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $renderer = $this->getMockBuilder('Phansible\Renderer\VagrantfileRenderer')
            ->setMethods(['renderFile'])
            ->getMock();

        $renderer->expects($this->once())
            ->method('renderFile')
            ->with($this->identicalTo($twig))
            ->will($this->returnValue('Vagrantfile'));

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(['addFromString'])
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('addFromString')
            ->with($this->equalTo('Vagrantfile'), 'Vagrantfile');

        $this->model->setTwig($twig);
        $this->model->addRenderer($renderer);
        $this->model->renderFiles($mockedZip);
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
