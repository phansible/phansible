<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class ElasticSearch extends BaseRole
{
    protected $name = 'ElasticSearch';
    protected $slug = 'elasticsearch';
    protected $role = 'elasticsearch';


    public function getInitialValues()
    {
        return [
            'install' => 0,
            'version' => '1.5.2',
            'port'    => '9200'
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
