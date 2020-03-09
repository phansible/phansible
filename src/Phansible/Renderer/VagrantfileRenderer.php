<?php
/**
 * Vagrantfile Renderer
 */

namespace App\Phansible\Renderer;

/**
 * Class VagrantfileRenderer
 * @package App\Phansible\Renderer
 */
class VagrantfileRenderer extends TemplateRenderer
{
    /**
     * @var string VM Name
     */
    protected $name;

    /**
     * @var  string Memory
     */
    protected $memory;

    /**
     * @var  string Box Name
     */
    protected $boxName;

    /**
     * @var  string Box URL
     */
    protected $boxUrl;

    /**
     * @var  string IP Address
     */
    protected $ipAddress;

    /**
     * @var  string Synced Folder
     */
    protected $syncedFolder;

    /**
     * @var  string Mount Point
     */
    protected $mountPoint;

    /**
     * @var  string Synced Folder Type
     */
    protected $syncedType;

    /**
     * {@inheritdoc}
     */
    public function loadDefaults(): void
    {
        $this->setTemplate('Vagrantfile.twig');
        $this->setFilePath('Vagrantfile');

        $this->setName('default');
        $this->setMemory('512');
        $this->setBoxName('ubuntu/trusty64');
        $this->setBoxUrl('');
        $this->setIpAddress('192.168.33.99');
        $this->setSyncedFolder('./');
        $this->setMountPoint('/vagrant');
        $this->setSyncedType('nfs');
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            'vmName'       => strtolower($this->getName()),
            'memory'       => $this->getMemory(),
            'boxUrl'       => $this->getBoxUrl(),
            'boxName'      => $this->getBoxName(),
            'ipAddress'    => $this->getIpAddress(),
            'syncedFolder' => $this->getSyncedFolder(),
            'mountPoint'   => $this->getMountPoint(),
            'syncedType'   => $this->getSyncedType(),
        ];
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName($name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getMemory(): string
    {
        return $this->memory;
    }

    /**
     * @param string $memory
     */
    public function setMemory($memory): void
    {
        $this->memory = $memory;
    }

    /**
     * @return string
     */
    public function getBoxUrl(): string
    {
        return $this->boxUrl;
    }

    /**
     * @param string $boxUrl
     */
    public function setBoxUrl($boxUrl): void
    {
        $this->boxUrl = $boxUrl;
    }

    /**
     * @return string
     */
    public function getBoxName(): string
    {
        return $this->boxName;
    }

    /**
     * @param string $boxName
     */
    public function setBoxName($boxName): void
    {
        $this->boxName = $boxName;
    }

    /**
     * @return string
     */
    public function getIpAddress(): string
    {
        return $this->ipAddress;
    }

    /**
     * @param string $ipAddress
     */
    public function setIpAddress($ipAddress): void
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return string
     */
    public function getSyncedFolder(): string
    {
        return $this->syncedFolder;
    }

    /**
     * @param string $syncedFolder
     */
    public function setSyncedFolder($syncedFolder): void
    {
        $this->syncedFolder = $syncedFolder;
    }

    /**
     * @return string
     */
    public function getMountPoint(): string
    {
        return $this->mountPoint;
    }

    /**
     * @param string $mountPoint
     */
    public function setMountPoint($mountPoint): void
    {
        $this->mountPoint = $mountPoint;
    }

    /**
     * @return string
     */
    public function getSyncedType(): string
    {
        return $this->syncedType;
    }

    /**
     * @param string $syncedType
     */
    public function setSyncedType($syncedType): void
    {
        $this->syncedType = $syncedType;
    }
}
