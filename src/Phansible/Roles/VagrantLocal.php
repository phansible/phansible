<?php

namespace App\Phansible\Roles;

use App\Phansible\Model\VagrantBundle;
use App\Phansible\Renderer\VagrantfileRenderer;
use App\Phansible\Role;
use App\Phansible\RoleValuesTransformer;
use Symfony\Component\Yaml\Yaml;

/**
 * Class VagrantLocal
 * @package App\Phansible\Roles
 */
class VagrantLocal implements Role, RoleValuesTransformer
{
    /**
     * @return string
     */
    public function getName(): string
    {
        return 'Local';
    }

    /**
     * @return string
     */
    public function getSlug(): string
    {
        return 'vagrant_local';
    }

    /**
     * @return string
     */
    public function getRole(): string
    {
        return 'vagrant_local';
    }

    /**
     * @return array
     */
    public function getInitialValues(): array
    {
        return [];
    }

    /**
     * @param array $values
     * @param VagrantBundle $vagrantBundle
     * @return array
     */
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
    private function getVagrantfile(array $config): VagrantfileRenderer
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

    /**
     * @param $boxName
     * @return array
     */
    private function getBox($boxName): array
    {
        $boxes = Yaml::parse(file_get_contents(__DIR__ . '/../../../config/phansible/boxes.yaml'))['boxes']['virtualbox'];
        $boxName = array_key_exists($boxName, $boxes) ? $boxName : 'trusty64';

        return $boxes[$boxName];
    }
}
