<?php

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;

use Fairway\FairwayFilesystemApi\File;
use Fairway\PixelboxxSaasApi\Client;
use Fairway\PixelboxxSaasApi\Model\Asset;
use Fairway\PixelboxxSaasApi\Utility\PixelboxxUtility;

final class PixelboxxFile extends File
{
    private ?Asset $asset = null;

    public function __construct(Driver $client, string $identifier)
    {
        parent::__construct($client, $identifier);
    }

    public function getPublicUrl(): string
    {
        return '';
    }

    public function getAsset(): Asset
    {
        if ($this->asset !== null) {
            return $this->asset;
        }
        /** @var Client $client */
        $client = $this->client->getClient();
        $this->asset = $client->assets()->getAsset($this->identifier)->getAsset();
        return $this->asset;
    }

    public function getFileName(): string
    {
        return $this->getAsset()->getName();
    }

    public function getATime(): int
    {
        return PixelboxxUtility::buildTimestamp($this->getAsset()->getCreated());
    }

    public function getMTime(): int
    {
        return PixelboxxUtility::buildTimestamp($this->getAsset()->getCreated());
    }

    public function getCTime(): int
    {
        return PixelboxxUtility::buildTimestamp($this->getAsset()->getCreated());
    }

    public function getExtension(): string
    {
        return $this->getAsset()->getAssetType();
    }
}
