<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

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

    /**
     * {@inheritdoc}
     */
    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        $playbook = $vagrantBundle->getPlaybook();
        if (!$playbook->hasRole('php')) {
            return;
        }

        parent::setup($requestVars, $vagrantBundle);
    }
}
