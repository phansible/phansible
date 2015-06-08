<?php

namespace Phansible\Roles;

use Phansible\Role;

class ElasticSearch implements Role
{
    public function getName()
    {
        return 'ElasticSearch';
    }

    public function getSlug()
    {
        return 'elasticsearch';
    }

    public function getRole()
    {
        return 'elasticsearch';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
            'version' => '1.5.2',
            'port'    => '9200'
        ];
    }
}
