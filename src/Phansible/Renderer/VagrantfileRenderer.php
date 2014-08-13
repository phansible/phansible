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
     * @param string $boxName
     */
    public function setBoxName($boxName)
    {
        $this->boxName = $boxName;
    }

    /**
     * @return string
     */
    public function getBoxName()
    {
        return $this->boxName;
    }

    /**
     * @param string $boxUrl
     */
    public function setBoxUrl($boxUrl)
    {
        $this->boxUrl = $boxUrl;
    }

    /**
     * @return string
     */
    public function getBoxUrl()
    {
        return $this->boxUrl;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param string $memory
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    /**
     * @return string
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $syncedFolder
     */
    public function setSyncedFolder($syncedFolder)
    {
        $this->syncedFolder = $syncedFolder;
    }

    /**
     * @return string
     */
    public function getSyncedFolder()
    {
        return $this->syncedFolder;
    }
} 