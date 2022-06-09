<?php

use Fairway\CantoSaasApi\Client;
use Fairway\CantoSaasApi\ClientOptions;
use Fairway\FairwayFilesystemApi\Adapter\CantoAdapter\CantoIdentifier;
use Fairway\FairwayFilesystemApi\Adapter\CantoAdapter\Driver;
use Fairway\FairwayFilesystemApi\FileType;

require 'vendor/autoload.php';

//$client = new PixelboxxClient('https://ecentral.demo.pixelboxx.io/servlet/api/v1.0');
//$client->authenticate('Christoph.Lauber', 'rfjgmzJPV5tev3vmf');

$adapter = new Driver(new Client(
    new ClientOptions([
        'cantoName' => 'ecentral',
        'cantoDomain' => 'canto.de',
        'appId' => '7b8091ae6d704804b9868b1c69ede981',
        'appSecret' => '4b2880c0db20408f919ea51fd90f2f106cdde08424ce4d8c8e954b8fdf95cdcd',
    ])
), 'christophlauber@gmx.net');

$fileSystem = new \Fairway\FairwayFilesystemApi\Driver($adapter);
$metadata = $fileSystem->exists(CantoIdentifier::buildIdentifier('folder', 'PN4DV'), FileType::Directory);
var_dump($metadata);
$metadata = $fileSystem->exists(CantoIdentifier::buildIdentifier('image', 'q84b4qsgc11u32mk1mvp4ovm4c'), FileType::File);
var_dump($metadata);
