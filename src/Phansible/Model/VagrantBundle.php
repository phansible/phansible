<?php
/**
 * Model for Vagrant Bundle
 */

namespace Phansible\Model;

use Phansible\Renderer\PlaybookRenderer;
use Phansible\Renderer\TemplateRenderer;
use Phansible\Renderer\VagrantfileRenderer;
use Phansible\Renderer\VarfileRenderer;

class VagrantBundle
{
    const VARSFILE = 'varsfile';
    const PLAYBOOK = 'playbook';
    const VAGRANTFILE = 'vagrantfile';
    const INVENTORY = 'inventory';


    /** @var array File Renderers */
    protected $renderers = [];

    /** @var string Path to Ansible Resources */
    protected $ansiblePath;

    /** @var string Path to Ansible Templates */
    protected $tplPath;

    /** @var string Path to Roles */
    private $rolesPath;

    /** @var \Twig_Environment */
    protected $twig;

    /**
     * @param string $ansiblePath
     * @param \Twig_Environment $twig
     */
    public function __construct($ansiblePath = null, \Twig_Environment $twig)
    {
        $this->twig = $twig;
        $this->ansiblePath = $ansiblePath ?: __DIR__ . '/../Resources/ansible';

        $this->tplPath   = $this->ansiblePath . '/templates';
        $this->rolesPath = $this->ansiblePath . '/roles';

        $this->renderers = [
            self::VARSFILE => null,
            self::PLAYBOOK => null,
            self::VAGRANTFILE => null,
        ];
    }

    /**
     * @param \Phansible\Renderer\PlaybookRenderer $playbook
     * @return $this
     */
    public function setPlaybook(PlaybookRenderer $playbook)
    {
        $this->addRenderer(self::PLAYBOOK, $playbook);
        return $this;
    }

    /**
     * @return \Phansible\Renderer\PlaybookRenderer
     */
    public function getPlaybook()
    {
        return $this->getRenderer(self::PLAYBOOK);
    }

    /**
     * @param \Phansible\Renderer\VarfileRenderer $varsfile
     * @return $this
     */
    public function setVarsFile(VarfileRenderer $varsfile)
    {
        $this->addRenderer(self::VARSFILE, $varsfile);
        return $this;
    }

    /**
     * @return \Phansible\Renderer\VarfileRenderer
     */
    public function getVarsFile()
    {
        return $this->getRenderer(self::VARSFILE);
    }

    /**
     * @param \Phansible\Renderer\VagrantfileRenderer $vagrantFile
     * @return $this
     */
    public function setVagrantFile(VagrantfileRenderer $vagrantFile)
    {
        $this->addRenderer(self::VAGRANTFILE, $vagrantFile);
        return $this;
    }

    /**
     * @return \Phansible\Renderer\VagrantfileRenderer
     */
    public function getVagrantFile()
    {
        return $this->getRenderer(self::VAGRANTFILE);
    }

    public function setInventory(TemplateRenderer $inventory)
    {
        $this->addRenderer(self::INVENTORY, $inventory);
        return $this;
    }

    /**
     * @param string $name
     * @param \Phansible\Model\FileRendererInterface $renderer
     */
    protected function addRenderer($name, FileRendererInterface $renderer)
    {
        $this->renderers[$name] = $renderer;
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getRenderer($name)
    {
        return $this->renderers[$name];
    }

    /**
     * @return \ZipArchive
     */
    public function getZipArchive()
    {
        return new \ZipArchive();
    }

    /**
     * @return string
     */
    public function getRolesPath()
    {
        return $this->rolesPath;
    }

    /**
     * @param string $path
     */
    public function setRolesPath($path)
    {
        $this->rolesPath = $path;
    }

    /**
     * Renders the files defined via FileRenderers
     * @param \ZipArchive $zip
     * @return \ZipArchive
     */
    protected function renderFiles(\ZipArchive $zip)
    {
        foreach ($this->renderers as $renderer) {
            $zip->addFromString($renderer->getFilePath(), $renderer->renderFile($this->twig));
        }

        return $zip;
    }

    /**
     * Generates a Vagrant Bundle based on given Roles and currently configured file renderers
     * @param string $filepath
     * @param array $roles
     * @return int
     */
    public function generateBundle($filepath, array $roles)
    {
        $zip = $this->getZipArchive();
        $res = $zip->open($filepath, \ZipArchive::CREATE);

        if ($res === true) {
            /** template files rendering */
            $this->renderFiles($zip);

            /** role folders */
            foreach ($roles as $role) {
                $this->addRoleFiles($role, $zip);
            }

            /** default var files */
            $this->includeBundleFiles($zip, 'vars', '*.yml', 'ansible/vars');

            /** include windows.sh */
            $zip->addFile($this->ansiblePath . '/windows.sh', 'ansible/windows.sh');

            /** include default public key */
            $zip->addFile($this->ansiblePath . '/files/authorized_keys', 'ansible/files/authorized_keys');

            $zip->close();

            return 1;
        }

        return 0;
    }

    /**
     * Includes Files in the Vagrant Bundle
     *
     * @param \ZipArchive $zip
     * @param string $sourceDir The source directory where to get the files from
     * @param string $pattern   Pattern to be used with glob
     * @param string $includePath Path to save the file inside the bundle, defaults to the same as sourceDir
     */
    public function includeBundleFiles(\ZipArchive $zip, $sourceDir, $pattern = '*.*', $includePath = null)
    {
        $includePath = $includePath ?: $sourceDir;

        $resources = $this->ansiblePath;

        if (is_dir($resources . '/' . $sourceDir)) {
            foreach (glob($resources . '/' . $sourceDir . '/' . $pattern) as $file) {
                $zip->addFile($file, $includePath . '/' . basename($file));
            }
        }
    }

    /**
     * Adds a Role directory inside a Vagrant Bundle
     * @param $role
     * @param \ZipArchive $zip
     */
    public function addRoleFiles($role, \ZipArchive $zip)
    {
        $base = 'roles/' . $role;

        /** tasks */
        $dirTasks = $base . '/defaults';
        $this->includeBundleFiles($zip, $dirTasks, '*.yml', 'ansible/' . $dirTasks);

        /** tasks */
        $dirTasks = $base . '/tasks';
        $this->includeBundleFiles($zip, $dirTasks, '*.yml', 'ansible/' . $dirTasks);

        /** handlers */
        $dirHandlers = $base . '/handlers';
        $this->includeBundleFiles($zip, $dirHandlers, '*.yml', 'ansible/' . $dirHandlers);

        /** templates */
        $dirTemplates = $base . '/templates';
        $this->includeBundleFiles($zip, $dirTemplates, '*.tpl', 'ansible/' . $dirTemplates);
    }
}
