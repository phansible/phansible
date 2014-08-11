<?php
/**
 * Abstract FileRenderer Test
 */

namespace Phansible\Model;

class AbstractFileRendererTest extends \PHPUnit_Framework_TestCase
{
    private $model;

    public function setUp()
    {
        $this->model = $this->getMockForAbstractClass('Phansible\Model\AbstractFileRenderer');
        $this->model->expects($this->any())
            ->method('getTemplate')
            ->will($this->returnValue('Vagrantfile.twig'));

        $this->model->expects($this->any())
            ->method('getData')
            ->will($this->returnValue(['key' => 'value']));
    }

    public function tearDown()
    {
        $this->model = null;
    }

    /**
     * @covers Phansible\Model\AbstractFileRenderer::renderFile
     */
    public function testRenderFile()
    {
        $twig = $this->getMockBuilder('Twig_Environment')
            ->disableOriginalConstructor()
            ->setMethods(array('render'))
            ->getMock();

        $twig->expects($this->once())
            ->method('render')
            ->with($this->equalTo('Vagrantfile.twig'), $this->model->getData());

        $this->model->renderFile($twig);
    }
}
 