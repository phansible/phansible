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

    public function getInitialValues()
    {
    }

    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        parent::setup($requestVars, $vagrantBundle);
        // Add vagrant file
        $vagrantFile = $this->getVagrantfile($requestVars);
        $vagrantBundle->setVagrantFile($vagrantFile);
    }

    /**
     * @param array $requestVars
     * @return VagrantfileRenderer
     */
    public function getVagrantfile(array $requestVars)
    {
        $config = $requestVars[$this->getSlug()];
        $boxName = $config['vm']['base_box'];
        $box = $this->getBox($boxName);

        if (! isset($config['vm']['enableWindows'])) {
            $config['vm']['enableWindows'] = false;
        }

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
        if (! isset($config['vm']['useVagrantCloud'])) {
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
        $boxes = $this->app['boxes']['virtualbox'];
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'precise64';

        return $boxes[$boxName];
    }
}
