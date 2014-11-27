<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \Phansible\Application(__DIR__ . '/..', true);
$app->configure(__DIR__ . '/../app/config/config.yml');
$app->run();
