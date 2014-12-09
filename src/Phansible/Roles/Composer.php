<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

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
