<?php

namespace Phansible\Roles;

use Phansible\Application;
use Phansible\Role;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\VagrantfileRenderer;

class VagrantLocal implements Role, RoleValuesTransformer
{
    /**
     * @var \Phansible\Application
     */
    private $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    public function getName()
    {
        return 'Local';
    }

    public function getSlug()
    {
        return 'vagrant_local';
    }

    public function getRole()
    {
        return 'vagrant_local';
    }

    public function getInitialValues()
    {
        return [];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle)
    {
        $vagrantFile = $this->getVagrantfile($values);
        $vagrantBundle->setVagrantFile($vagrantFile);

        return $values;
    }

    /**
     * @param array $config
     * @return VagrantfileRenderer
     */
    private function getVagrantfile(array $config)
    {
        $boxName = $config['vm']['base_box'];
        $box = $this->getBox($boxName);

        $vagrantfile = new VagrantfileRenderer();
        $vagrantfile->setTemplate('vagrant_local.twig');
        $vagrantfile->setName($config['vm']['hostname']);
        $vagrantfile->setBoxName($box['cloud']);
        $vagrantfile->setMemory($config['vm']['memory']);
        $vagrantfile->setIpAddress($config['vm']['ip']);
        $vagrantfile->setSyncedFolder($config['vm']['sharedfolder']);
        $vagrantfile->setMountPoint($config['vm']['mountPoint']);
        $vagrantfile->setSyncedType($config['vm']['syncType']);

        // Add box url when NOT using the vagrant cloud
        if (! isset($config['vm']['useVagrantCloud'])) {
             $vagrantfile->setBoxUrl($box['url']);
        }

        return $vagrantfile;
    }

    private function getBox($boxName)
    {
        $boxes = $this->app['boxes']['virtualbox'];
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'precise64';

        return $boxes[$boxName];
    }
}
