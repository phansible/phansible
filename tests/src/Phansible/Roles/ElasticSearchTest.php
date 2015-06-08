<?php

namespace Phansible\Roles;

class ElasticSearchTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers Phansible\Roles\ElasticSearch::getInitialValues
     */
    public function testShouldGetInitialValues()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new ElasticSearch($app);

        $expected = [
            'install'   => 0,
            'port'      => '9200',
            'version'   => '1.5.2'
        ];

        $this->assertEquals($expected, $role->getInitialValues());
    }

    /**
     * @covers Phansible\Roles\ElasticSearch::setup
     */
    public function testShouldRetriveNullWhenRoleIsNotInstalled()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new ElasticSearch($app);

        $requestVars = [
            'elasticsearch' => [
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
     * @covers Phansible\Roles\ElasticSearch::setup
     */
    public function testShouldSetupRole()
    {
        $app = $this->getMockBuilder('\Phansible\Application')
            ->disableOriginalConstructor()
            ->getMock();

        $role = new ElasticSearch($app);

        $requestVars = [
            'elasticsearch' => [
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
                'elasticsearch' => [
                    'install' => '1',
                    'version' => '1.5.2'
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
