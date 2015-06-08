<?php

namespace Phansible\Roles;

class SolrTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Phansible\Roles\Solr::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new Solr($app);

        $expected = [
            'install'   => 0,
            'port'      => '8983',
            'version'   => '5.2.0'
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }

    /**
     * @covers Phansible\Roles\Solr::setup
     */
    public function testShouldRetriveNullWhenRoleIsNotInstalled()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new Solr($app);

        $requestVars = [
            'solr' => [
                'install' => '0'
            ]
        ];

        $twig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $playbook = new \Phansible\Renderer\PlaybookRenderer();

        $bundle = new \Phansible\Model\VagrantBundle('/path/ansible', $twig);
        $bundle->setPlaybook($playbook);

        $role->setup($requestVars, $bundle);

        $this->assertEmpty($bundle->getPlaybook()->getRoles());
    }

    /**
     * @covers Phansible\Roles\Solr::setup
     */
    public function testShouldSetupRole()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new Solr($app);

        $requestVars = [
            'solr' => [
                'install' => '1'
            ]
        ];

        $varfile = $this->getMockBuilder('\Phansible\Renderer\VarfileRenderer')
            ->disableOriginalConstructor()
            ->setMethods(['addMultipleVars'])
            ->getMock();

        $varfile->expects($this->once())
            ->method('addMultipleVars')
            ->with([
                'solr' => [
                    'install' => '1',
                    'version' => '5.2.0'
                ]
            ]);

        $twig = $this->getMockBuilder('\Twig_Environment')
            ->disableOriginalConstructor()
            ->getMock();

        $playbook = new \Phansible\Renderer\PlaybookRenderer();

        $bundle = new \Phansible\Model\VagrantBundle('/path/ansible', $twig);
        $bundle->setPlaybook($playbook);
        $bundle->setVarsfile($varfile);

        $role->setup($requestVars, $bundle);

        $this->assertContains($role->getSlug(), $bundle->getPlaybook()->getRoles());
    }
}
