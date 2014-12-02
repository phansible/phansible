<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

class Php extends BaseRole
{
    protected $name = 'PHP';
    protected $slug = 'php';
    protected $role = 'php';


    public function getInitialValues()
    {
        return [
          'install' => 1,
          'packages' => [
            'php5-cli',
            'php5-intl',
            'php5-mcrypt',
          ],
          'peclpackages' => []
        ];
    }

    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        $playbook = $vagrantBundle->getPlaybook();
        if ($playbook->hasRole('mysql') || $playbook->hasRole('mariadb')) {
            // $this->addPhpPackage('php5-mysql');
        } elseif ($playbook->hasRole('pgsql')) {
            // $this->addPhpPackage('php5-pgsql');
        }

        parent::setup($requestVars, $vagrantBundle);
    }
}
