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
            'php5.6-cli',
            'php5.6-intl',
            'php5.6-mcrypt',
          ],
          'peclpackages' => []
        ];
    }

    public function transformValues(array $values, VagrantBundle $vagrantBundle)
    {

        $map = $this->getPackagesMap($values['php_version']);
        $playbook = $vagrantBundle->getPlaybook();

        foreach ($map as $role => $package) {
            if ($playbook->hasRole($role)) {
                $values = $this->addPhpPackage($package, $values);
            }
        }

        return $values;
    }

    private function getPackagesMap($php_version)
    {
        $map_php = [
            'mysql'   => 'php' . $php_version . '-mysql',
            'mariadb' => 'php' . $php_version . '-mysql',
            'pgsql'   => 'php' . $php_version . '-pgsql',
            'sqlite'  => 'php' . $php_version . '-sqlite',
            'mongodb' => 'php' . $php_version . '-mongo',
        ];

        return $map_php;
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
