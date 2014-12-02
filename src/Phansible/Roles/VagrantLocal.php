<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;
use Phansible\Renderer\VagrantfileRenderer;

class VagrantLocal extends BaseRole
{
    protected $name = 'Local';
    protected $slug = 'vagrant-local';
    protected $role = null;

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
        $config = $requestVars['vagrantfile-local'];
        // $name = $config['vm']['name'];
        // $boxName = $config['vm']['box_url'];
        // $boxName = $request->get('baseBox') ?: 'precise64';
        // $box = $this->getBox($boxName);

        $vagrantfile = new VagrantfileRenderer();
        $vagrantfile->setTemplate('vagrantfile-local.twig');
        $vagrantfile->setName($config['vm']['name']);
        $vagrantfile->setBoxName($config['vm']['box_url']);
        $vagrantfile->setMemory($config['vm']['memory']);
        $vagrantfile->setIpAddress($config['vm']['ip']);
        $vagrantfile->setSyncedFolder($config['vm']['sharedfolder']);
        $vagrantfile->setEnableWindows($config['vm']['enableWindows']);
        $vagrantfile->setSyncedType($config['vm']['syncType']);

        ///if (!$request->get('useVagrantCloud')) {
        //     $vagrantfile->setBoxUrl($box['url']);
        //}

        return $vagrantfile;
    }

}
