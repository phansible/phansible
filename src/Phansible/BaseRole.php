<?php

namespace Phansible;

use Phansible\Renderer\PlaybookRenderer;
use Symfony\Component\HttpFoundation\Request;

abstract class BaseRole implements RoleInterface
{
  protected $app;

  public function __construct() {
  }

  public abstract function setup(Request $request, PlaybookRenderer $playbook);
}
