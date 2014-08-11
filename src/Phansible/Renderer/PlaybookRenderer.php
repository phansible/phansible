<?php
/**
 * Playbook Renderer
 */

namespace Phansible\Renderer;

use Phansible\Model\AbstractFileRenderer;

class PlaybookRenderer extends AbstractFileRenderer
{
    /** @var  array Playbook Variables */
    protected $vars;

    /** @var  array Playbook Vars Files */
    protected $varsFiles;

    /** @var  array Playbook Roles */
    protected $roles;

    /**
     * {@inheritdoc}
     */
    public function loadDefaults()
    {
        $this->vars      = [];
        $this->varsFiles = [];
        $this->roles     = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getTemplate()
    {
        return 'playbook.yml.twig';
    }

    /**
     * {@inheritdoc}
     */
    public function getFilePath()
    {
        return 'ansible/playbook.yml';
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [
            'web_server'      => isset($this->vars['web_server']) ? $this->vars['web_server'] : 'nginxphp',
            'playbook_vars'   => $this->vars,
            'playbook_files'  => $this->varsFiles,
            'playbook_roles'  => $this->roles,
        ];
    }

    /**
     * @param array $vars
     */
    public function setVars(array $vars = [])
    {
        $this->vars = $vars;
    }

    /**
     * @return array
     */
    public function getVars()
    {
        return $this->vars;
    }

    /**
     * @param string $key
     * @param mixed $value
     */
    public function addVar($key, $value)
    {
        $this->vars[$key] = $value;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function getVar($key)
    {
        return isset($this->vars[$key]) ? $this->vars[$key] : null;
    }

    /**
     * @param array $varsFiles
     */
    public function setVarsFiles(array $varsFiles = [])
    {
        $this->varsFiles = $varsFiles;
    }

    /**
     * @return array
     */
    public function getVarsFiles()
    {
        return $this->varsFiles;
    }

    /**
     * @param string $varfile
     */
    public function addVarsFile($varfile)
    {
        $this->varsFiles[] = $varfile;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles = [])
    {
        $this->roles = $roles;
    }

    /**
     * @return array
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * @param string $role
     */
    public function addRole($role)
    {
        $this->roles[] = $role;
    }
}