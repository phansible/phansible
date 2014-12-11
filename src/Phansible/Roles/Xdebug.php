<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Xdebug extends BaseRole
{
    protected $name = 'XDebug';
    protected $slug = 'xdebug';
    protected $role = 'xdebug';

    /**
     * {@inheritdoc}
     */
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
        if (!$this->installRole($requestVars, 'php')) {
            return;
        }

        parent::setup($requestVars, $vagrantBundle);
    }
}
