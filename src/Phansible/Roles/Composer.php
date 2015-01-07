<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Composer extends BaseRole
{
    protected $name = 'Composer';
    protected $slug = 'composer';
    protected $role = 'composer';

    public function getInitialValues()
    {
        return [
          'install' => 0,
        ];
    }

    protected function installRole($requestVars)
    {
        return parent::installRole($requestVars) && $this->phpWillBeInstalled($requestVars);
    }

    private function phpWillBeInstalled($requestVars)
    {
        $config = $requestVars['php'];

        if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] == 0) {
            return false;
        }
        return true;
    }
}
