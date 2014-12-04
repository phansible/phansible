<?php
/**
 * Vagrantfile Renderer
 */

namespace Phansible\Renderer;

class VagrantfileRenderer extends TemplateRenderer
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

    /** @var  string Synced Folder Type */
    protected $syncedType;

    /** @var  bool Enables or Disables Windows support (windows.sh) */
    protected $enableWindows;

    /**
     * {@inheritdoc}
     */
    public function loadDefaults()
    {
        $this->setTemplate('Vagrantfile.twig');
        $this->setFilePath('Vagrantfile');

        $this->setName('default');
        $this->setMemory('512');
        $this->setBoxName('ubuntu/trusty64');
        $this->setBoxUrl('');
        $this->setIpAddress('192.168.33.99');
        $this->setSyncedFolder('./');
        $this->setSyncedType('nfs');
        $this->setEnableWindows(true);
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [
            'vmName'        => strtolower($this->getName()),
            'memory'        => $this->getMemory(),
            'boxUrl'        => $this->getBoxUrl(),
            'boxName'       => $this->getBoxName(),
            'ipAddress'     => $this->getIpAddress(),
            'syncedFolder'  => $this->getSyncedFolder(),
            'syncedType'    => $this->getSyncedType(),
            'enableWindows' => $this->getEnableWindows(),
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

    /**
     * @param string $syncedType
     */
    public function setSyncedType($syncedType)
    {
        $this->syncedType = $syncedType;
    }

    /**
     * @return string
     */
    public function getSyncedType()
    {
        return $this->syncedType;
    }

    /**
     * @param boolean $enableWindows
     */
    public function setEnableWindows($enableWindows)
    {
        $this->enableWindows = $enableWindows;
    }

    /**
     * @return boolean
     */
    public function getEnableWindows()
    {
        return $this->enableWindows;
    }
}
