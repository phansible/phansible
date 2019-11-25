<?php

require __DIR__ . '/../vendor/autoload.php';

$app = new \Phansible\Application(__DIR__ . '/..');
$app->configure(__DIR__ . '/../app/config/config.config');
$app->run();
