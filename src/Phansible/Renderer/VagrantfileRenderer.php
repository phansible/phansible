<?php
/**
 * Vagrantfile Renderer
 */

namespace Phansible\Renderer;

use Phansible\Model\AbstractFileRenderer;

class VagrantfileRenderer extends AbstractFileRenderer
{
    /** @var string VM Name */
    protected $name;

    /** @var  string Memory */
    protected $memory;

    /** @var  string Box Name */
    protected $boxName;

    /** @var  string Box URL */
    protected $boxUrl;

    /** @var  string IP Address */
    protected $ipAddress;

    /** @var  string Synced Folder */
    protected $syncedFolder;

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'Vagrantfile.twig';
    }
    /**
     * {@inheritdoc}
     */
    public function getFilePath()
    {
        return 'Vagrantfile';
    }

    /**
     * {@inheritdoc}
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