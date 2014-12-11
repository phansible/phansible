<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Composer extends BaseRole
{
    protected $name = 'Composer';
    protected $slug = 'composer';
    protected $role = 'composer';

    /**
     * {@inheritdoc}
     */
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

        if (!$this->installRole($requestVars, 'php')) {
            return;
        }

        parent::setup($requestVars, $vagrantBundle);
    }
}
