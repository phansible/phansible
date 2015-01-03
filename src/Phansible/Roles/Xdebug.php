<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Xdebug extends BaseRole
{
    protected $name = 'XDebug';
    protected $slug = 'xdebug';
    protected $role = 'xdebug';

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'settings' => [],
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
