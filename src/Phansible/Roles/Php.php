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

    /**
     * {@inheritdoc}
     */
    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        if (!$this->installRole($requestVars)) {
            return;
        }

        $playbook = $vagrantBundle->getPlaybook();
        $roleMap  = $this->getRolePackageMap();

        foreach ($roleMap as $role => $package) {
            if ($playbook->hasRole($role)) {
                $this->addPhpPackage($package, $requestVars);
            }
        }

        parent::setup($requestVars, $vagrantBundle);
    }

    /**
     * @param string $package
     * @param array $requestVars
     * @throws \Exception
     */
    protected function addPhpPackage($package, &$requestVars)
    {
        if (in_array($package, $requestVars[$this->getSlug()]['packages']) === false) {
            $requestVars[$this->getSlug()]['packages'][] = $package;
        }
    }

    /**
     * @return array
     */
    private function getRolePackageMap()
    {
        if (!isset($this->app['rolepackagemap'][$this->getSlug()])) {
            return [];
        }

        return $this->app['rolepackagemap'][$this->getSlug()];
    }
}
