<?php

namespace Phansible\Roles;

use Phansible\Role;

class Solr implements Role
{
    public function getName()
    {
        return 'Solr';
    }

    public function getSlug()
    {
        return 'solr';
    }

    public function getRole()
    {
        return 'solr';
    }

    public function getInitialValues()
    {
        return [
            'install' => 0,
            'version' => '5.2.0',
            'port'    => '8983'
        ];
    }
}
