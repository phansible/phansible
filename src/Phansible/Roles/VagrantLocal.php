<?php

namespace App\Phansible\Roles;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\Renderer\VagrantfileRenderer;
use App\Phansible\Role;
use App\Phansible\RoleValuesTransformer;
use Symfony\Component\Yaml\Yaml;

class VagrantLocal implements Role, RoleValuesTransformer
{
    public function getName(): string
    {
        return 'Local';
    }

    public function getSlug(): string
    {
        return 'vagrant_local';
    }

    public function getRole(): string
    {
        return 'vagrant_local';
    }

    public function getInitialValues(): array
    {
        return [];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle): array
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
        $box     = $this->getBox($boxName);

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
        if (!isset($config['vm']['useVagrantCloud'])) {
            $vagrantfile->setBoxUrl($box['url']);
        }

        return $vagrantfile;
    }

    private function getBox($boxName)
    {
        $boxes = Yaml::parse(file_get_contents('../config/phansible/boxes.yaml'));
        var_dump($boxes);
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'precise64';

        return $boxes[$boxName];
    }
}
