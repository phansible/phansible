<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Solr extends BaseRole
{
    protected $name = 'Solr';
    protected $slug = 'solr';
    protected $role = 'solr';


    public function getInitialValues()
    {
        return [
            'install' => 0,
            'version' => '5.2.0',
            'port'    => '8983'
        ];
    }

    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        if (!$this->installRole($requestVars)) {
            return;
        }

        $requestVars[$this->getSlug()]['version'] = $this->getInitialValues()['version'];

        parent::setup($requestVars, $vagrantBundle);
    }
}
