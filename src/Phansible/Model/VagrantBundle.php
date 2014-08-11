<?php
/**
 * Model for Vagrant Bundle
 */

namespace Phansible\Model;

class VagrantBundle
{
    /** File Renderers */
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
     */
    public function __construct($ansiblePath = null)
    {
        $this->ansiblePath = $ansiblePath ?: __DIR__ . '/../Resources/ansible';

        $this->tplPath   = $this->ansiblePath . '/templates';
        $this->rolesPath = $this->ansiblePath . '/roles';

        $loader = new \Twig_Loader_Filesystem($this->tplPath);
        $this->twig = new \Twig_Environment($loader);
    }

    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }

    /**
     * @param string $tplPath
     */
    public function setTplPath($tplPath)
    {
        $this->tplPath = $tplPath;
    }

    /**
     * @return string
     */
    public function getTplPath()
    {
        return $this->tplPath;
    }

    /**
     * @param string $ansiblePath
     */
    public function setAnsiblePath($ansiblePath)
    {
        $this->ansiblePath = $ansiblePath;
    }

    /**
     * @return string
     */
    public function getAnsiblePath()
    {
        return $this->ansiblePath;
    }

    /**
     * @param array $renderers
     */
    public function setRenderers(array $renderers)
    {
        foreach ($renderers as $renderer) {
            $this->addRenderer($renderer);
        }

        $this->renderers = $renderers;
    }

    /**
     * @return array
     */
    public function getRenderers()
    {
        return $this->renderers;
    }

    /**
     * @param FileRenderer $renderer
     */

    public function addRenderer(FileRenderer $renderer)
    {
        $this->renderers[] = $renderer;
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
    public function renderFiles(\ZipArchive $zip)
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

        if ($res === TRUE) {

            /** template files rendering */
            $this->renderFiles($zip);

            /** role folders */
            foreach ($roles as $role) {
                $this->addRoleFiles($role, $zip);
            }

            /** default var files */
            $this->includeBundleFiles($zip, 'vars', '*.yml', 'ansible/vars');

            $zip->close();

            return 1;

        } else {

            return 0;
        }
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

        $resources = $this->getAnsiblePath();

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
