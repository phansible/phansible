<?php

namespace Phansible\Model;

use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VagrantfileRenderer;
use Symfony\Component\HttpFoundation\Request;

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
     * @covers Phansible\Model\VagrantBundle::getAnsiblePath
     * @covers Phansible\Model\VagrantBundle::setAnsiblePath
     */
    public function testShouldSetAndGetAnsiblePath()
    {
        $path = __DIR__ . '/../src/Resources/ansible';
        $this->model->setAnsiblePath($path);

        $this->assertEquals($path, $this->model->getAnsiblePath());
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getTplPath
     * @covers Phansible\Model\VagrantBundle::setTplPath
     */
    public function testShouldSetAndGetTplPath()
    {
        $path = __DIR__ . '/../src/Resources/ansible';
        $this->model->setTplPath($path);

        $this->assertEquals($path, $this->model->getTplPath());
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getRolesPath
     * @covers Phansible\Model\VagrantBundle::setRolesPath
     */
    public function testShouldSetAndGetRolesPath()
    {
        $path = __DIR__ . '/../src/Resources/ansible';
        $this->model->setRolesPath($path);

        $this->assertEquals($path, $this->model->getRolesPath());
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

        $this->assertTrue(is_dir($ansiblePath));

        $this->model->setAnsiblePath($ansiblePath);
        $this->model->includeBundleFiles($mockedZip, 'vars');
    }

    /**
     * @covers Phansible\Model\VagrantBundle::renderFiles
     */
    public function testShouldRenderFile()
    {
        $this->markTestSkipped('must be revisited.');
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
        // $this->model->addRenderer($renderer);
        // $this->model->renderFiles($mockedZip);
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
