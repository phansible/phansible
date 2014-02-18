<?php
/**
 * Model for Vagrant Bundle
 */

namespace Phansible\Model;

class VagrantBundle
{
    /** Vagrantfile options */
    protected $box;
    protected $boxUrl;
    protected $ipAddress;
    protected $syncedFolder;

    /** Provisioner options */
    protected $webserver;
    protected $docRoot;
    protected $phpPPA;
    protected $syspackages;
    protected $phppackages;
    protected $installComposer;

    protected $twig;
    protected $tplPath;

    public function __construct($tplPath = null)
    {
        $this->tplPath = $tplPath ?: __DIR__ . '/../Resources/ansible';

        $loader = new \Twig_Loader_Filesystem($this->tplPath);
        $this->twig = new \Twig_Environment($loader);
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
     * @param mixed $phppackages
     */
    public function setPhpPackages($phppackages)
    {
        $this->phppackages = $phppackages;
    }

    /**
     * @return mixed
     */
    public function getPhpPackages()
    {
        return $this->phppackages;
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
     * @param mixed $webserver
     */
    public function setWebserver($webserver)
    {
        $this->webserver = $webserver;
    }

    /**
     * @return mixed
     */
    public function getWebserver()
    {
        return $this->webserver;
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


    public function renderVagrantfile()
    {
        $data = [
            'ipAddress'    => $this->ipAddress,
            'boxName'      => $this->box,
            'boxUrl'       => $this->boxUrl,
            'syncedFolder' => $this->syncedFolder,
        ];

        return $this->twig->render('Vagrantfile.twig', $data);
    }

    public function renderPlaybook(array $tasks = [])
    {
        $data = [
            'doc_root'     => $this->docRoot,
            'php_packages' => count($this->phppackages) ? json_encode($this->phppackages) : '[]',
            'sys_packages' => count($this->syspackages) ? json_encode($this->syspackages) : '[]',
            'web_server'   => $this->webserver,
            'php_ppa'      => $this->phpPPA,
            'tasks'        => $tasks,
        ];

        return $this->twig->render('playbook.yml.twig', $data);
    }


    public function generateBundle($filepath)
    {
        $zip = new \ZipArchive();
        $res = $zip->open($filepath, \ZipArchive::CREATE);

        if ($res === TRUE) {

            /** set tasks */
            $tasks = [
                'init', $this->webserver
            ];

            if ($this->installComposer) {
                $tasks[] = 'composer';
            }

            foreach ($tasks as $task) {
                $this->addTask($task, $zip);
            }

            /** adds the Vagrantfile */
            $zip->addFromString('Vagrantfile', $this->renderVagrantfile());

            /** adds the playbook */
            $zip->addFromString('ansible/playbook.yml', $this->renderPlaybook($tasks));

            $zip->close();

            return 1;

        } else {

            return 0;
        }
    }

    protected function addTask($task, \ZipArchive $zip)
    {
        $resouces = __DIR__ . '/../Resources/ansible';

        /** tasks */
        if (is_dir($resouces . '/' . $task . '/tasks')) {

            foreach (glob($resouces . '/' . $task . '/tasks/*.yml') as $taskfile) {
                $zip->addFile($taskfile, 'ansible/' . $task . '/tasks/' . basename($taskfile));
            }
        }

        /** templates */
        if (is_dir($resouces . '/' . $task . '/templates')) {

            foreach (glob($resouces . '/' . $task . '/templates/*.tpl') as $tplfile) {
                $zip->addFile($tplfile, 'ansible/' . $task . '/templates/' . basename($tplfile));
            }
        }
    }
} 