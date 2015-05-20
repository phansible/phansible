<?php

namespace Phansible\Roles;

use Phansible\BaseRole;

class Blackfire extends BaseRole
{
    protected $name = 'BlackFire';
    protected $slug = 'blackfire';
    protected $role = 'blackfire';

    public function getInitialValues()
    {
        return [
          'install' => 0,
          'server_id' => '',
          'server_token' => '',
        ];
    }

    protected function installRole($requestVars)
    {
        return parent::installRole($requestVars) && $this->blackfireWillBeInstalled($requestVars);
    }

    private function blackfireWillBeInstalled($requestVars)
    {
        $config = $requestVars['blackfire'];

        if (!is_array($config) || !array_key_exists('install', $config) || $config['install'] == 0) {
            return false;
        }
        return true;
    }
}
