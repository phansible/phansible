<?php
/**
 * Playbook Renderer
 */

namespace Phansible\Renderer;

class PlaybookRenderer extends TemplateRenderer
{
    /** @var array Playbook Variables */
    protected $vars;

    /** @var array[VarfileRenderer] VarsFiles */
    protected $varsFiles;

    /** @var array Playbook Roles */
    protected $roles;

    /**
     * {@inheritdoc}
     */
    public function loadDefaults()
    {
        $this->setTemplate('playbook.yml.twig');
        $this->setFilePath('ansible/playbook.yml');

        $this->vars      = [];
        $this->varsFiles = [];
        $this->roles     = [];
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return [
            'web_server'      => isset($this->vars['web_server']) ? $this->vars['web_server'] : 'nginxphp',
            'playbook_vars'   => $this->vars,
            'playbook_files'  => $this->getVarsFilesList(),
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
        foreach ($varsFiles as $varFile) {
            $this->addVarsFile($varFile);
        }
    }

    /**
     * @return array
     */
    public function getVarsFiles()
    {
        return $this->varsFiles;
    }

    public function getVarsFilesList()
    {
        $include = [];
        foreach ($this->varsFiles as $varFile) {
            $include[] = 'vars/'. $varFile->getName() . '.yml';
        }

        return $include;
    }

    /**
     * @param VarFileRenderer $varfile
     */
    public function addVarsFile(VarfileRenderer $varfile)
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

    public function createVarsFile($name, array $data, $template = null)
    {
        $varfile = new VarfileRenderer($name);
        $varfile->setData($data);

        if ($template) {
            $varfile->setTemplate($template);
        }

        $this->addVarsFile($varfile);
    }
}
