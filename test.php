<?php

use Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter\Driver as PixelboxxDriver;
use Fairway\PixelboxxSaasApi\Client as PixelboxxClient;
use Fairway\PixelboxxSaasApi\PixelboxxResourceName;

require 'vendor/autoload.php';

$adapter = new PixelboxxDriver(
    PixelboxxClient::createWithDomain('ecentral.demo.pixelboxx.io')
        ->authenticate('Christoph.Lauber', 'rfjgmzJPV5tev3vmf')
);

$rootDirectory = $adapter->listDirectory();
$directory = [];
foreach ($rootDirectory as $item) {
    $directory[] = $adapter->getDirectory(PixelboxxResourceName::prnFromResource(
        $adapter->getClient(),
        PixelboxxResourceName::FOLDER,
        $item->getIdentifier(),
    ));
}
var_dump($directory);
die();

