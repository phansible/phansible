<?php

namespace Phansible;

use Phansible\Model\VagrantBundle;

interface RoleValuesTransformer
{
    /**
     * Transforms the configuration values
     *
     * @param array $values The list of options of the role.
     * @param VagrantBundle $vagrantBundle This is required biy PHP role, Should not be used.
     * @return array The final configuration of the role.
     */
    public function transformValues(array $values, VagrantBundle $vagrantBundle): array;
}
