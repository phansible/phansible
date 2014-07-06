<?php

namespace Phansible\Model;

class VagrantBundleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var VagrantBundle;
     */
    private $model;

    public function setUp()
    {
        $this->model = new VagrantBundle();
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
     * @covers Phansible\Model\VagrantBundle::getMemory
     * @covers Phansible\Model\VagrantBundle::setMemory
     */
    public function testShouldSetAndGetMemory()
    {
        $memory = 512;

        $this->model->setMemory($memory);

        $result = $this->model->getMemory();

        $this->assertEquals($memory, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getVmName
     * @covers Phansible\Model\VagrantBundle::setVmName
     */
    public function testShouldSetAndGetVmName()
    {
        $vmName = 'phansible';

        $this->model->setVmName($vmName);

        $result = $this->model->getVmName();

        $this->assertEquals($vmName, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getBox
     * @covers Phansible\Model\VagrantBundle::setBox
     */
    public function testShouldSetAndGetBox()
    {
        $box = 'precise64';

        $this->model->setBox($box);

        $result = $this->model->getBox();

        $this->assertEquals($box, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getBoxUrl
     * @covers Phansible\Model\VagrantBundle::setBoxUrl
     */
    public function testShouldSetAndGetBoxUrl()
    {
        $boxUrl = 'http://files.vagrantup.com/precise64.box';

        $this->model->setBoxUrl($boxUrl);

        $result = $this->model->getBoxUrl();

        $this->assertEquals($boxUrl, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getIpAddress
     * @covers Phansible\Model\VagrantBundle::setIpAddress
     */
    public function testShouldSetAndGetIpAddress()
    {
        $ipAddress = '192.168.100.100';

        $this->model->setIpAddress($ipAddress);

        $result = $this->model->getIpAddress();

        $this->assertEquals($ipAddress, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getSyncedFolder
     * @covers Phansible\Model\VagrantBundle::setSyncedFolder
     */
    public function testShouldSetAndGetSyncedFolder()
    {
        $syncedFolder = './';

        $this->model->setSyncedFolder($syncedFolder);

        $result = $this->model->getSyncedFolder();

        $this->assertEquals($syncedFolder, $result);
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
     * @covers Phansible\Model\VagrantBundle::getDocRoot
     * @covers Phansible\Model\VagrantBundle::setDocRoot
     */
    public function testShouldSetAndGetDocRoot()
    {
        $docRoot = '/vagrant';

        $this->model->setDocRoot($docRoot);

        $result = $this->model->getDocRoot();

        $this->assertEquals($docRoot, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getPhpPackages
     * @covers Phansible\Model\VagrantBundle::setPhpPackages
     */
    public function testShouldSetAndGetPhpPackages()
    {
        $phpPackages = array();

        $this->model->setPhpPackages($phpPackages);

        $result = $this->model->getPhpPackages();

        $this->assertEquals($phpPackages, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getSyspackages
     * @covers Phansible\Model\VagrantBundle::setSyspackages
     */
    public function testShouldSetAndGetSyspackages()
    {
        $syspackages = array();

        $this->model->setSyspackages($syspackages);

        $result = $this->model->getSyspackages();

        $this->assertEquals($syspackages, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getPhpPPA
     * @covers Phansible\Model\VagrantBundle::setPhpPPa
     */
    public function testShouldSetAndGetPhpPPA()
    {
        $phpPPA = true;

        $this->model->setPhpPPA($phpPPA);

        $result = $this->model->getPhpPPA();

        $this->assertEquals($phpPPA, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getInstallComposer
     * @covers Phansible\Model\VagrantBundle::setInstallComposer
     */
    public function testShouldSetAndGetInstallComposer()
    {
        $composer = true;

        $this->model->setInstallComposer($composer);

        $result = $this->model->getInstallComposer();

        $this->assertEquals($composer, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getRoles
     * @covers Phansible\Model\VagrantBundle::addRoles
     * @covers Phansible\Model\VagrantBundle::addRole
     */
    public function testShouldAddAndGetRoles()
    {
        $roles = array('nginx', 'php');

        $this->model->addRoles($roles);

        $this->assertEquals($roles, $this->model->getRoles());

        $this->model->addRole('init');

        $roles[] = 'init';

        $this->assertEquals($roles, $this->model->getRoles());
    }

    /**
     * @covers Phansible\Model\VagrantBundle::getTimezone
     * @covers Phansible\Model\VagrantBundle::setTimezone
     */
    public function testShouldSetAndGetTimezone()
    {
        $timezone = 'UTC';

        $this->model->setTimezone($timezone);

        $this->assertEquals($timezone, $this->model->getTimezone());
    }

    /**
     * @covers Phansible\Model\VagrantBundle::renderVagrantfile
     */
    public function testShouldRenderVagrantfile()
    {
        $this->model->setVmName('phansible');
        $this->model->setMemory(512);
        $this->model->setIpAddress('192.168.100.100');
        $this->model->setBox('precise64');
        $this->model->setBoxUrl('http://files.vagrantup.com/precise64.box');
        $this->model->setSyncedFolder('./');

        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $data = array(
            'vmName'       => 'phansible',
            'memory'       => 512,
            'ipAddress'    => '192.168.100.100',
            'boxName'      => 'precise64',
            'boxUrl'       => 'http://files.vagrantup.com/precise64.box',
            'syncedFolder' => './'
        );

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('Vagrantfile.twig'), $data);

        $this->model->setTwig($twig);

        $result = $this->model->renderVagrantfile();
    }

    /**
     * @covers Phansible\Model\VagrantBundle::renderPlaybook
     */
    public function testShouldRenderPlaybook()
    {
        $this->model->setDocRoot('/vagrant');
        $this->model->setPhpPackages(array('php5-cli', 'php-pear'));
        $this->model->setSyspackages(array('vim', 'git'));
        $this->model->setPhpPPA(true);
        $this->model->setTimezone('UTC');

        $mockedTwig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $data = array(
            'doc_root' => '/vagrant',
            'php_packages' => json_encode(array('php5-cli', 'php-pear')),
            'sys_packages' => json_encode(array('vim', 'git')),
            'php_ppa'      => true,
            'roles'        => array('nginx'),
            'timezone'    => 'UTC'
        );

        $mockedTwig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('playbook.yml.twig'), $data);

        $roles = array('nginx');

        $this->model->setTwig($mockedTwig);
        $this->model->renderPlaybook($roles);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::renderPlaybook
     * @covers Phansible\Model\VagrantBundle::setMysqlVars
     */
    public function testShouldRenderPlaybookWithMysqlVars()
    {
        $this->model->setDocRoot('/vagrant');
        $this->model->setPhpPackages(array());
        $this->model->setSyspackages(array());
        $this->model->setPhpPPA(true);
        $this->model->setTimezone('UTC');

        $mockedTwig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $data = array(
            'doc_root'     => '/vagrant',
            'php_packages' => json_encode(array()),
            'sys_packages' => json_encode(array()),
            'php_ppa'      => true,
            'roles'        => array('nginx', 'mysql'),
            'timezone'     => 'UTC',
            'mysql_user'   => 'user',
            'mysql_pass'   => 'password',
            'mysql_db'     => 'database'
        );

        $mockedTwig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('playbook.yml.twig'), $data);

        $roles = array('nginx', 'mysql');

        $this->model->setTwig($mockedTwig);
        $this->model->setMysqlVars(array(
            'user' => 'user',
            'pass' => 'password',
            'db'   => 'database',
        ));
        $this->model->renderPlaybook($roles);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::renderPlaybook
     */
    public function testShouldRenderPlaybookWithoutPackages()
    {
        $this->model->setDocRoot('/vagrant');
        $this->model->setPhpPPA(true);
        $this->model->setTimezone('UTC');

        $mockedTwig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $data = array(
            'doc_root' => '/vagrant',
            'php_packages' => '[]',
            'sys_packages' => '[]',
            'php_ppa'      => true,
            'roles'        => array('nginx'),
            'timezone'    => 'UTC'
        );

        $mockedTwig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('playbook.yml.twig'), $data);

        $roles = array('nginx');

        $this->model->setTwig($mockedTwig);
        $this->model->renderPlaybook($roles);
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
     * @covers Phansible\Model\VagrantBundle::setRolesPath
     */
    public function testShouldSetAndGetRolesPath()
    {
        $path   = 'ansible/roles/';

        $this->model->setRolesPath($path);

        $result = $this->model->getRolesPath();

        $this->assertEquals($path, $result);
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

        $result = $model->generateBundle($filePath);

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
            ->setMethods(array('getZipArchive', 'renderVagrantfile', 'renderPlaybook'))
            ->getMock();

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('open', 'addFromString', 'close'))
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->will($this->returnValue(true));

        $mockedZip->expects($this->at(1))
            ->method('addFromString')
            ->with('Vagrantfile', 'renderVagrantfile');

        $mockedZip->expects($this->at(2))
            ->method('addFromString')
            ->with('ansible/playbook.yml', 'renderPlaybook');

        $model->expects($this->once())
            ->method('getZipArchive')
            ->will($this->returnValue($mockedZip));

        $model->expects($this->once())
            ->method('renderVagrantfile')
            ->will($this->returnValue('renderVagrantfile'));

        $model->expects($this->once())
            ->method('renderPlaybook')
            ->with(array())
            ->will($this->returnValue('renderPlaybook'));

        $result = $model->generateBundle($filePath);

        $this->assertEquals(1, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::generateBundle
     */
    public function testShouldRetrieveOneWhenGenerateBundleWithRoles()
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(array('getZipArchive', 'renderVagrantfile', 'renderPlaybook', 'addRoleFiles'))
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

        $model->expects($this->once())
            ->method('renderVagrantfile')
            ->will($this->returnValue('renderVagrantfile'));

        $roles = array('phpcommon');

        $model->expects($this->once())
            ->method('renderPlaybook')
            ->with($roles)
            ->will($this->returnValue('renderPlaybook'));

        $model->addRoles($roles);

        $result = $model->generateBundle($filePath);

        $this->assertEquals(1, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::generateBundle
     */
    public function testShouldRetrieveOneWhenGenerateBundleWithComposeRole()
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(array('getZipArchive', 'renderVagrantfile', 'renderPlaybook', 'addRoleFiles'))
            ->getMock();

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('open', 'addFromString', 'close'))
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->will($this->returnValue(true));

        $mockedZip->expects($this->at(1))
            ->method('addFromString')
            ->with('Vagrantfile', 'renderVagrantfile');

        $mockedZip->expects($this->at(2))
            ->method('addFromString')
            ->with('ansible/playbook.yml', 'renderPlaybook');

        $model->expects($this->once())
            ->method('getZipArchive')
            ->will($this->returnValue($mockedZip));

        $model->expects($this->once())
            ->method('renderVagrantfile')
            ->will($this->returnValue('renderVagrantfile'));

        $model->expects($this->once())
            ->method('renderPlaybook')
            ->with(array())
            ->will($this->returnValue('renderPlaybook'));

        $model->setInstallComposer(true);

        $result = $model->generateBundle($filePath);

        $this->assertEquals(1, $result);
    }

    /**
     * @covers Phansible\Model\VagrantBundle::addRoleFiles
     */
    public function testShouldAddRolesFilesIntoZip()
    {
        $filePath = '/tmp/file.zip';

        $model = $this->getMockBuilder('Phansible\Model\VagrantBundle')
            ->disableOriginalConstructor()
            ->setMethods(array('getZipArchive', 'renderVagrantfile', 'renderPlaybook'))
            ->getMock();

        $mockedZip = $this->getMockBuilder('\ZipArchive')
            ->setMethods(array('open', 'addFromString', 'close', 'addFile'))
            ->getMock();

        $mockedZip->expects($this->once())
            ->method('open')
            ->will($this->returnValue(true));

        $php = \PHPUnit_Extension_FunctionMocker::start($this, __NAMESPACE__)
            ->mockFunction('is_dir')
            ->mockFunction('glob')
            ->getMock();

        $rolePath = 'ansible/roles/phpcommon';

        $php->expects($this->at(0))
            ->method('is_dir')
            ->with($rolePath . '/tasks')
            ->will($this->returnValue(true));

        $php->expects($this->at(2))
            ->method('is_dir')
            ->with($rolePath . '/handlers')
            ->will($this->returnValue(true));

        $php->expects($this->at(4))
            ->method('is_dir')
            ->with($rolePath . '/templates')
            ->will($this->returnValue(true));

        $php->expects($this->at(1))
            ->method('glob')
            ->with($rolePath . '/tasks/*.yml')
            ->will($this->returnValue(array('main.yml')));

        $php->expects($this->at(3))
            ->method('glob')
            ->with($rolePath . '/handlers/*.yml')
            ->will($this->returnValue(array('main.yml')));

        $php->expects($this->at(5))
            ->method('glob')
            ->with($rolePath . '/templates/*.tpl')
            ->will($this->returnValue(array('template.tpl')));

        $mockedZip->expects($this->at(1))
            ->method('addFile')
            ->with('main.yml', $rolePath . '/tasks/main.yml');

        $mockedZip->expects($this->at(2))
            ->method('addFile')
            ->with('main.yml', $rolePath . '/handlers/main.yml');

        $mockedZip->expects($this->at(3))
            ->method('addFile')
            ->with('template.tpl', $rolePath . '/templates/template.tpl');

        $model->expects($this->once())
            ->method('getZipArchive')
            ->will($this->returnValue($mockedZip));

        $model->expects($this->once())
            ->method('renderVagrantfile')
            ->will($this->returnValue('renderVagrantfile'));

        $roles = array('phpcommon');

        $model->expects($this->once())
            ->method('renderPlaybook')
            ->with($roles)
            ->will($this->returnValue('renderPlaybook'));

        $model->addRoles($roles);
        $model->setRolesPath('ansible/roles');

        $result = $model->generateBundle($filePath);

        $this->assertEquals(1, $result);
    }
}
