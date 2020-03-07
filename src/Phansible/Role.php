<?php

namespace App\Phansible;

interface Role
{
    /**
     * Get extension's English name, eg "Apache"
     *
     * @return string
     */
    public function getName(): string;

    /**
     * Get url-friendly slug, eg "vagrantfile-local"
     *
     * @return string
     */
    public function getSlug(): string;

    /**
     * Get role name, eg "php"
     *
     * @return string
     */
    public function getRole(): string;

    /**
     * Get initial values for the form
     *
     * @return array
     */
    public function getInitialValues(): array;
}
