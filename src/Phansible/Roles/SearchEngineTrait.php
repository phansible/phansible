<?php

namespace Phansible\Roles;

use Phansible\BaseRole;
use Phansible\Model\VagrantBundle;

trait SearchEngineTrait
{
    public function setup(array $requestVars, VagrantBundle $vagrantBundle)
    {
        if (!$this->installRole($requestVars)) {
            return;
        }

        $requestVars[$this->getSlug()]['version'] = $this->getInitialValues()['version'];

        parent::setup($requestVars, $vagrantBundle);
    }
}
