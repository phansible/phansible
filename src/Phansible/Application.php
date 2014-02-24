<?php

namespace Phansible;

/**
 * @package Phansible
 */
class Application extends \Flint\Application
{

    public function __construct($rootDir, $debug = true, array $parameters = array())
    {
        $parameters += array('config.cache_dir' => $rootDir . '/app/cache/config');

        parent::__construct($rootDir, $debug, $parameters);
    }
}
