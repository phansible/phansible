<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Apache extends BaseRole
{
    protected $name = 'Apache';
    protected $slug = 'apache';
    protected $role = 'apache';

    public function getInitialValues()
    {
        return [
            'install' => 0,
            'docroot' => '/vagrant',
            'servername' => 'myApp.vb'
        ];
    }
}
