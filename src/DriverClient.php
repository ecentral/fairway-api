<?php

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi;

interface DriverClient extends Filesystem
{
    public function hasAssetPicker(): bool;

    public function getAssetPicker(): string;

    public function getFile(string $identifier): File;

    public function getMetadata(string $identifier): array;

    public function getPublicUrl(string $identifier): string;
}
