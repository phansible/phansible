<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseRole implements RoleInterface
{
    protected $app;
    protected $name;
    protected $slug;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Get extension's English name, eg "Apache"
     *
     * @return string
     * @throws \Exception
     */
    public function getName()
    {
        if (!$this->name) {
            throw new \Exception('Extension name has not been defined');
        }
        return $this->name;
    }
    /**
     * Get url-friendly slug, eg "vagrantfile-local"
     *
     * @return string
     * @throws \Exception
     */
    public function getSlug()
    {
        if (!$this->slug) {
            throw new \Exception('Extension slug has not been defined');
        }
        return $this->slug;
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     * @param \Phansible\Renderer\PlaybookRenderer $playbook
     * @return mixed
     */
    public abstract function setup(
      Request $request,
      PlaybookRenderer $playbook
    );
}
