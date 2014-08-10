<?php
/**
 * Model for Vagrant Bundle
 */

namespace Phansible\Model;

use Phansible\Renderer\PlaybookRenderer;

class VagrantBundle
{
    /** Vagrantfile options */
    protected $vmName;
    protected $memory;
    protected $box;
    protected $boxUrl;
    protected $ipAddress;
    protected $syncedFolder;

    /** Playbook options */
    protected $docRoot;
    protected $phpPPA;
    protected $syspackages;
    protected $phppackages = array();
    protected $installComposer;
    protected $timezone='Europe/Brussels';
    protected $mysql = [];
    protected $installXdebug = false;

    /** File Renderers */
    protected $renderers = [];
    protected $roles = [];
    private   $rolesPath;

    protected $twig;
    protected $tplPath;

    public function __construct($tplPath = null)
    {
        $this->tplPath = $tplPath ?: __DIR__ . '/../Resources/ansible';

        $loader = new \Twig_Loader_Filesystem($this->tplPath);
        $this->twig = new \Twig_Environment($loader);
    }

    /**
     * @param mixed $memory
     */
    public function setMemory($memory)
    {
        $this->memory = $memory;
    }

    /**
     * @return mixed
     */
    public function getMemory()
    {
        return $this->memory;
    }

    /**
     * @param mixed $vmName
     */
    public function setVmName($vmName)
    {
        $this->vmName = $vmName;
    }

    /**
     * @return mixed
     */
    public function getVmName()
    {
        return $this->vmName;
    }

    /**
     * @param mixed $box
     */
    public function setBox($box)
    {
        $this->box = $box;
    }

    /**
     * @return mixed
     */
    public function getBox()
    {
        return $this->box;
    }

    /**
     * @param mixed $boxUrl
     */
    public function setBoxUrl($boxUrl)
    {
        $this->boxUrl = $boxUrl;
    }

    /**
     * @return mixed
     */
    public function getBoxUrl()
    {
        return $this->boxUrl;
    }

    /**
     * @param mixed $ipAddress
     */
    public function setIpAddress($ipAddress)
    {
        $this->ipAddress = $ipAddress;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ipAddress;
    }

    /**
     * @param mixed $syncedFolder
     */
    public function setSyncedFolder($syncedFolder)
    {
        $this->syncedFolder = $syncedFolder;
    }

    /**
     * @return mixed
     */
    public function getSyncedFolder()
    {
        return $this->syncedFolder;
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
     * @param mixed $docRoot
     */
    public function setDocRoot($docRoot)
    {
        $this->docRoot = $docRoot;
    }

    /**
     * @return mixed
     */
    public function getDocRoot()
    {
        return $this->docRoot;
    }

    /**
     * @param array $phppackages
     */
    public function setPhpPackages(array $phppackages)
    {
        $this->phppackages = $phppackages;
    }

    /**
     * @return array
     */
    public function getPhpPackages()
    {
        return $this->phppackages;
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
     * @param mixed $syspackages
     */
    public function setSyspackages($syspackages)
    {
        $this->syspackages = $syspackages;
    }

    /**
     * @return mixed
     */
    public function getSyspackages()
    {
        return $this->syspackages;
    }

    /**
     * @param mixed $phpPPA
     */
    public function setPhpPPA($phpPPA)
    {
        $this->phpPPA = $phpPPA;
    }

    /**
     * @return mixed
     */
    public function getPhpPPA()
    {
        return $this->phpPPA;
    }

    /**
     * @param mixed $installComposer
     */
    public function setInstallComposer($installComposer)
    {
        $this->installComposer = $installComposer;
    }

    /**
     * @return mixed
     */
    public function getInstallComposer()
    {
        return $this->installComposer;
    }

    /**
     * @param mixed $timezone
     */
    public function setTimezone($timezone)
    {
        $this->timezone = $timezone;
    }

    /**
     * @return mixed
     */
    public function getTimezone()
    {
        return $this->timezone;
    }

    /**
     * @param array $vars
     */
    public function setMysqlVars(array $vars)
    {
        $this->mysql = $vars;
    }

    /**
     * @return array
     */
    public function getMysqlVars()
    {
        return $this->mysql;
    }

    /**
     * @param boolean $installXdebug
     */
    public function setInstallXdebug($installXdebug)
    {
        $this->installXdebug = $installXdebug;
    }

    /**
     * @return boolean
     */
    public function getInstallXdebug()
    {
        return $this->installXdebug;
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

    public function getZipArchive()
    {
        return new \ZipArchive();
    }

    public function getRolesPath()
    {
        if (null === $this->rolesPath) {
            $this->rolesPath = __DIR__ . '/../Resources/ansible/roles';
        }
        return $this->rolesPath;
    }

    public function setRolesPath($path)
    {
        $this->rolesPath = $path;
    }

    public function renderVagrantfile()
    {
        $data = [
            'vmName'       => $this->vmName,
            'memory'       => $this->memory,
            'ipAddress'    => $this->ipAddress,
            'boxName'      => $this->box,
            'boxUrl'       => $this->boxUrl,
            'syncedFolder' => $this->syncedFolder,
        ];

        return $this->twig->render('Vagrantfile.twig', $data);
    }

    public function renderPlaybook(array $roles = [])
    {
        $renderer = new PlaybookRenderer($this->twig);

        return $renderer->renderPlaybook($roles, $this);
    }

    public function renderFiles(\ZipArchive $zip)
    {
        foreach ($this->renderers as $renderer) {
            $zip->addFromString($renderer->getFilePath(), $renderer->renderFile($this->twig));
        }

        return $zip;
    }

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
