<?php

namespace Phansible\Roles;

use Phansible\RoleInterface;
use Phansible\Model\VagrantBundle;

class Hhvm implements RoleInterface
{
    public function getName()
    {
        return 'HHVM';
    }

    public function getSlug()
    {
        return 'hhvm';
    }

    public function getRole()
    {
        return 'hhvm';
    }

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'host' => '127.0.0.1',
          'port' => 9000,
        ];
    }
}
