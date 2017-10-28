<?php

namespace Phansible\Roles;

use Phansible\Role;
use Phansible\RoleValuesTransformer;
use Phansible\Model\VagrantBundle;

class Php implements Role, RoleValuesTransformer
{
    public function getName()
    {
        return 'PHP';
    }

    public function getSlug()
    {
        return 'php';
    }

    public function getRole()
    {
        return 'php';
    }

    public function getInitialValues()
    {
        return [
          'install' => 1,
          'packages' => [
            'cli',
            'intl',
            'mcrypt',
          ],
          'peclpackages' => []
        ];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle)
    {
        $map = [
            "mysql"   => "mysql",
            "mariadb" => "mysql",
            "pgsql"   => "pgsql",
            "sqlite"  => "sqlite",
            "mongodb" => "mongo",
        ];

        $playbook = $vagrantBundle->getPlaybook();

        foreach ($map as $role => $package) {
            if ($playbook->hasRole($role)) {
                $values = $this->addPhpPackage($package, $values);
            }
        }

        return $values;
    }

    /**
     * @param string $package
     * @param array $requestVars
     */
    protected function addPhpPackage($package, $values)
    {
        if (in_array($package, $values['packages']) === false) {
            $values['packages'][] = $package;
        }

        return $values;
    }
}
