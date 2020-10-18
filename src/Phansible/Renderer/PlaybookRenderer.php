<?php
/**
 * Playbook Renderer
 */

namespace App\Phansible\Renderer;

class PlaybookRenderer extends TemplateRenderer
{
    /**
     * @var string
     */
    protected $varsFilename;

    /**
     * @var array Playbook Roles
     */
    protected $roles = [];

    /**
     * {@inheritdoc}
     */
    public function loadDefaults(): void
    {
        $this->setTemplate('playbook.yml.twig');
        $this->setFilePath('ansible/playbook.yml');
    }

    /**
     * {@inheritdoc}
     */
    public function getData(): array
    {
        return [
            'varsfile' => $this->varsFilename,
            'roles'    => $this->roles,
        ];
    }

    /**
     * @param string $varsFilename
     */
    public function setVarsFilename(string $varsFilename): void
    {
        $this->varsFilename = $varsFilename;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles = []): void
    {
        $this->roles = $roles;
    }

    /**
     * @param string $role
     */
    public function addRole(string $role): void
    {
        $this->roles[] = $role;
    }

    /**
     * @param string $role
     * @return boolean
     */
    public function hasRole(string $role): bool
    {
        return in_array($role, $this->roles, true);
    }
}
