<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Apache extends BaseRole
{
    protected $name = 'Apache';
    protected $slug = 'apache';
    protected $role = 'apache';

    public function getInitialValues()
    {
        return [
            'install' => 1,
            'docroot' => '/vagrant',
            'servername' => 'myApp.vb'
        ];
    }
}
