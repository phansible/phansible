<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;
use Phansible\RoleWithDependencies;

class Xdebug implements Role, RoleWithDependencies, RoleValuesTransformer
{
    public function getName()
    {
        return 'XDebug';
    }

    public function getSlug()
    {
        return 'xdebug';
    }

    public function getRole()
    {
        return 'xdebug';
    }

    public function requiredRolesToBeInstalled()
    {
        return ['php'];
    }

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'settings' => [],
        ];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle)
    {
        if ($values['install'] == 1) {
            $values['settings'] = [
                'xdebug.remote_enable' => 1,
                'xdebug.remote_connect_back' => 1,
                'xdebug.max_nesting_level' => 300
            ];
        }

        return $values;
    }
}
