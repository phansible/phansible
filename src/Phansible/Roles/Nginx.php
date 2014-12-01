<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\VarfileRenderer;
use Symfony\Component\HttpFoundation\Request;

class Nginx extends Apache
{
    protected $name = 'Nginx';
    protected $slug = 'nginx';
    protected $role = 'nginx';

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'docroot' => '/vagrant',
          'servername' => 'myApp.vb'
        ];
    }
}
