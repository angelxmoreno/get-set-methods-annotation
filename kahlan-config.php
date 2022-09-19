<?php
/**
 * @var Kahlan\Cli\Kahlan $this
 */

use Kahlan\Cli\CommandLine;

$spec_dir = implode(DS, [
    __DIR__,
    'tests',
    '',
]);

define('SAMPLE_CLASS_PATH', implode(DS, [
    __DIR__,
    'tests',
    'sampleClass',
    ''
]));


/** @var CommandLine $commandLine */
$commandLine = $this->commandLine();
$commandLine->option('spec', 'default', $spec_dir);
$commandLine->option('cc', 'default', true);
$commandLine->option('reporter', 'default', 'verbose');
