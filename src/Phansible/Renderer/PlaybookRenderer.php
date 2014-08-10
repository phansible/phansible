<?php
/**
 * Playbook Renderer
 */

namespace Phansible\Renderer;

use Phansible\Model\AbstractFileRenderer;
use Phansible\Model\VagrantBundle;

class PlaybookRenderer extends AbstractFileRenderer
{
    protected $vars;
    protected $varsFiles;
    protected $roles;

    public function loadDefaults()
    {
        $this->vars      = [];
        $this->varsFiles = [];
        $this->roles     = [];
    }

    public function getTemplate()
    {
        return 'playbook.yml.twig';
    }

    /**
     * FilePath for saving the rendered template in the bundle
     */
    public function getFilePath()
    {
        return 'ansible/playbook.yml.twig';
    }

    /**
     * Returns the data for the template
     * @return Array
     */
    public function getData()
    {
        return [
            'web_server'      => isset($this->vars['web_server']) ? $this->vars['web_server'] : 'nginx',
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

    public function addVar($key, $value)
    {
        $this->vars[$key] = $value;
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

    public function addVarFile($varfile)
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

    public function addRole($role)
    {
        $this->roles[] = $role;
    }
}