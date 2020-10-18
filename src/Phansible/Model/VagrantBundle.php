<?php
/**
 * Model for Vagrant Bundle
 */

namespace App\Phansible\Model;

use App\Phansible\Renderer\PlaybookRenderer;
use App\Phansible\Renderer\TemplateRenderer;
use App\Phansible\Renderer\VagrantfileRenderer;
use App\Phansible\Renderer\VarfileRenderer;
use App\Phansible\Roles\VagrantLocal;
use Twig\Environment;
use ZipArchive;

/**
 * Class VagrantBundle
 * @package App\Phansible\Model
 */
class VagrantBundle
{
    public const VARSFILE = 'varsfile';
    public const PLAYBOOK = 'playbook';
    public const VAGRANTFILE = 'vagrantfile';
    public const INVENTORY = 'inventory';

    /** @var array File Renderers */
    protected $renderers = [];

    /** @var string Path to Ansible Resources */
    protected $ansiblePath;

    /** @var Environment */
    protected $twig;

    /**
     * @param string $ansiblePath
     * @param Environment $twig
     */
    public function __construct(string $ansiblePath, Environment $twig)
    {
        $this->twig        = $twig;
        $this->ansiblePath = $ansiblePath;

        $this->renderers = [
            self::VARSFILE    => null,
            self::PLAYBOOK    => null,
            self::VAGRANTFILE => null,
        ];
    }

    /**
     * @param PlaybookRenderer $playbook
     * @return VagrantBundle
     */
    public function setPlaybook(PlaybookRenderer $playbook): self
    {
        $this->addRenderer(self::PLAYBOOK, $playbook);

        return $this;
    }

    /**
     * @param string $name
     * @param FileRendererInterface $renderer
     */
    protected function addRenderer(string $name, FileRendererInterface $renderer): void
    {
        $this->renderers[$name] = $renderer;
    }

    /**
     * @return PlaybookRenderer
     */
    public function getPlaybook(): PlaybookRenderer
    {
        return $this->getRenderer(self::PLAYBOOK);
    }

    /**
     * @param string $name
     * @return mixed
     */
    protected function getRenderer(string $name)
    {
        return $this->renderers[$name];
    }

    /**
     * @param VarfileRenderer $varsfile
     * @return VagrantBundle
     */
    public function setVarsFile(VarfileRenderer $varsfile): self
    {
        $this->addRenderer(self::VARSFILE, $varsfile);

        return $this;
    }

    /**
     * @return VarfileRenderer
     */
    public function getVarsFile(): VarfileRenderer
    {
        return $this->getRenderer(self::VARSFILE);
    }

    /**
     * @param VagrantfileRenderer $vagrantFile
     * @return VagrantBundle
     * @see VagrantLocal
     */
    public function setVagrantFile(VagrantfileRenderer $vagrantFile): self
    {
        $this->addRenderer(self::VAGRANTFILE, $vagrantFile);

        return $this;
    }

    /**
     * @return VagrantfileRenderer
     */
    public function getVagrantFile(): VagrantfileRenderer
    {
        return $this->getRenderer(self::VAGRANTFILE);
    }

    /**
     * @param TemplateRenderer $inventory
     * @return VagrantBundle
     */
    public function setInventory(TemplateRenderer $inventory): VagrantBundle
    {
        $this->addRenderer(self::INVENTORY, $inventory);

        return $this;
    }

    /**
     * Generates a Vagrant Bundle based on given Roles and currently configured file renderers
     * @param string $filepath
     * @param array $roles
     * @return bool
     */
    public function generateBundle(string $filepath, array $roles): bool
    {
        $zip = $this->getZipArchive();
        $res = $zip->open($filepath, ZipArchive::OVERWRITE);

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

            return true;
        }

        return false;
    }

    /**
     * @return ZipArchive
     */
    public function getZipArchive(): ZipArchive
    {
        return new ZipArchive();
    }

    /**
     * Renders the files defined via FileRenderers
     * @param ZipArchive $zip
     * @return ZipArchive
     */
    protected function renderFiles(ZipArchive $zip): ZipArchive
    {
        foreach ($this->renderers as $renderer) {
            $zip->addFromString($renderer->getFilePath(), $renderer->renderFile($this->twig));
        }

        return $zip;
    }

    /**
     * Adds a Role directory inside a Vagrant Bundle
     * @param $role
     * @param ZipArchive $zip
     */
    public function addRoleFiles($role, ZipArchive $zip): void
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

    /**
     * Includes Files in the Vagrant Bundle
     *
     * @param ZipArchive $zip
     * @param string $sourceDir The source directory where to get the files from
     * @param string $pattern Pattern to be used with glob
     * @param null | string $includePath Path to save the file inside the bundle, defaults to the same as sourceDir
     */
    public function includeBundleFiles(ZipArchive $zip, string $sourceDir, $pattern = '*.*', $includePath = null): void
    {
        $includePath = $includePath ?: $sourceDir;

        $resources = $this->ansiblePath;

        if (is_dir($resources . '/' . $sourceDir)) {
            foreach (glob($resources . '/' . $sourceDir . '/' . $pattern) as $file) {
                $zip->addFile($file, $includePath . '/' . basename($file));
            }
        }
    }
}
