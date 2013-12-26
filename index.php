<?php

// load composers autoloader
require __DIR__ . '/vendor/autoload.php';

// load config
$config = require __DIR__ . '/config.php';

// create and run Dingbat
(new \Dingbat\App($config))->run();
