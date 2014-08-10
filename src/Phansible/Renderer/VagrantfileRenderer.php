<?php
/**
 * Vagrantfile Renderer
 */

namespace Phansible\Renderer;


use Phansible\Model\AbstractFileRenderer;

class VagrantfileRenderer extends AbstractFileRenderer
{
    protected $name;
    protected $memory;
    protected $boxName;
    protected $boxUrl;
    protected $ipAddress;
    protected $syncedFolder;

    /**
     * Loads any default values
     * @return void
     */
    public function loadDefaults()
    {
        $this->setName('Default');
        $this->setMemory('512');
        $this->setBoxUrl('http://files.vagrantup.com/precise64.box');
        $this->setBoxName('precise64');
        $this->setIpAddress('192.168.33.99');
        $this->setSyncedFolder('./');
    }

    /**
     * Template to be used for rendering
     * @return string
     */
    public function getTemplate()
    {
        return 'Vagrantfile.twig';
    }

    /**
     * FilePath for saving the rendered template
     */
    public function getFilePath()
    {
        return 'Vagrantfile';
    }

    /**
     * Returns the data for the template
     * @return Array
     */
    public function getData()
    {
        return [
            'vmName'       => $this->getName(),
            'memory'       => $this->getMemory(),
            'boxUrl'       => $this->getBoxUrl(),
            'boxName'      => $this->getBoxName(),
            'ipAddress'    => $this->getIpAddress(),
            'syncedFolder' => $this->getSyncedFolder()
        ];
    }

    /**
     * @param mixed $boxName
     */
    public function setBoxName($boxName)
    {
        $this->boxName = $boxName;
    }

    /**
     * @return mixed
     */
    public function getBoxName()
    {
        return $this->boxName;
    }

    /**
     * @param mixed $boxUrl
     */
    public function setBoxUrl($boxUrl)
    {
        $this->boxUrl = $boxUrl;
    }

    /**
     * @return mixed
     */
    public function getBoxUrl()
    {
        return $this->boxUrl;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $memory
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $syncedFolder
     */
    public function setSyncedFolder($syncedFolder)
    {
        $this->syncedFolder = $syncedFolder;
    }

    /**
     * @return mixed
     */
    public function getSyncedFolder()
    {
        return $this->syncedFolder;
    }
} 