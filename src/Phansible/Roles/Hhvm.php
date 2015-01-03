<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Hhvm extends BaseRole
{
    protected $name = 'HHVM';
    protected $slug = 'hhvm';
    protected $role = 'hhvm';


    public function getInitialValues()
    {
        return [
          'install' => 0,
          'host' => '127.0.0.1',
          'port' => 9000,
        ];
    }

    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        parent::setup($requestVars, $vagrantBundle);

        /*
        if ($requestVars[$this->getSlug()]['composer'] == 1) {
            $vagrantBundle->getPlaybook()->addRole('composer');
        }
        */
    }
}
