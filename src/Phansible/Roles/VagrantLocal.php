<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\VagrantfileRenderer;

class VagrantLocal extends BaseRole
{
    protected $name = 'Local';
    protected $slug = 'vagrant_local';
    protected $role = 'vagrant_local';

    public function setup(VagrantBundle $vagrantBundle)
    {
        parent::setup($vagrantBundle);
        // Add vagrant file
        $vagrantFile = $this->getVagrantfile();
        $vagrantBundle->setVagrantFile($vagrantFile);
    }

    /**
     * @return VagrantfileRenderer
     */
    public function getVagrantfile()
    {
        $config = $this->getData();
        $boxName = $config['vm']['base_box'];
        $box = $this->getBox($boxName);

        $vagrantfile = new VagrantfileRenderer();
        $vagrantfile->setTemplate('vagrant_local.twig');
        $vagrantfile->setName($config['vm']['hostname']);
        $vagrantfile->setBoxName($box['cloud']);
        $vagrantfile->setMemory($config['vm']['memory']);
        $vagrantfile->setIpAddress($config['vm']['ip']);
        $vagrantfile->setSyncedFolder($config['vm']['sharedfolder']);
        $vagrantfile->setEnableWindows($config['vm']['enableWindows']);
        $vagrantfile->setSyncedType($config['vm']['syncType']);

        // Add box url when NOT using the vagrant cloud
        if ($config['vm']['useVagrantCloud'] != 1) {
             $vagrantfile->setBoxUrl($box['url']);
        }

        return $vagrantfile;
    }

    /**
     * @param string $boxName
     * @return string
     */
    public function getBox($boxName)
    {
        $availableData = $this->getAvailableOptions();
        $boxes = $availableData['boxes']['virtualbox'];
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'precise64';

        return $boxes[$boxName];
    }
}
