<?php

require __DIR__.'/vendor/autoload.php';

use EgrnXml2CsvConv\Command\ConvertCommand;
use Symfony\Component\Console\Application;

$application = new Application();

$application->add(new ConvertCommand());
$application->setDefaultCommand('convert', true);

$application->run();