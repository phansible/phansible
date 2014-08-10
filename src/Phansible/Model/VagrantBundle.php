<?php
/**
 * Model for Vagrant Bundle
 */

namespace Phansible\Model;

use Phansible\Renderer\PlaybookRenderer;

class VagrantBundle
{
    /** File Renderers */
    protected $renderers = [];

    /** @var string Roles Path */
    private $rolesPath;

    protected $twig;
    protected $tplPath;

    public function __construct($tplPath = null)
    {
        $this->tplPath = $tplPath ?: __DIR__ . '/../Resources/ansible';

        $loader = new \Twig_Loader_Filesystem($this->tplPath);
        $this->twig = new \Twig_Environment($loader);
    }

    /**
     * @param mixed $twig
     */
    public function setTwig($twig)
    {
        $this->twig = $twig;
    }

    /**
     * @return mixed
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
     * @param string $phppackage
     *
     * @return void
     */
    public function addPhpPackage($phppackage)
    {
        if (!in_array($phppackage, $this->phppackages)) {
            $this->phppackages[] = $phppackage;
        }
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
        if (null === $this->rolesPath) {
            $this->rolesPath = __DIR__ . '/../Resources/ansible/roles';
        }
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
     * @param $filepath
     * @param array $roles
     * @return int
     */
    public function generateBundle($filepath, array $roles)
    {
        $zip = $this->getZipArchive();
        $res = $zip->open($filepath, \ZipArchive::CREATE);

        if ($res === TRUE) {

            // generate the templated files
            $this->renderFiles($zip);

            // include role folders
            foreach ($roles as $role) {
                $this->addRoleFiles($role, $zip);
            }

            $zip->close();

            return 1;

        } else {

            return 0;
        }
    }

    protected function addRoleFiles($role, \ZipArchive $zip)
    {
        $resources = $this->getRolesPath();

        /** default var files */
        if (is_dir($resources . '/vars')) {

            foreach (glob($resources . '/vars/*.yml') as $varfile) {
                $zip->addFile($varfile, 'ansible/vars/' . basename($varfile));
            }
        }

        /** tasks */
        if (is_dir($resources . '/' . $role . '/tasks')) {

            foreach (glob($resources . '/' . $role . '/tasks/*.yml') as $taskfile) {
                $zip->addFile($taskfile, 'ansible/roles/' . $role . '/tasks/' . basename($taskfile));
            }
        }

        /** handlers */
        if (is_dir($resources . '/' . $role . '/handlers')) {

            foreach (glob($resources . '/' . $role . '/handlers/*.yml') as $taskfile) {
                $zip->addFile($taskfile, 'ansible/roles/' . $role . '/handlers/' . basename($taskfile));
            }
        }

        /** templates */
        if (is_dir($resources . '/' . $role . '/templates')) {

            foreach (glob($resources . '/' . $role . '/templates/*.tpl') as $tplfile) {
                $zip->addFile($tplfile, 'ansible/roles/' . $role . '/templates/' . basename($tplfile));
            }
        }
    }
}
