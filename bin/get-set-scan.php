#!/usr/bin/env php
<?php
define('DS', DIRECTORY_SEPARATOR);
define('VENDOR_DIR', dirname(__DIR__) . DS . 'vendor' . DS);

include VENDOR_DIR . 'autoload.php';

$paths = $argv;
array_shift($paths);


$info = \Axm\GetSetAnnotations\Analyser::path($paths[0]);

print_r($info);

echo PHP_EOL;