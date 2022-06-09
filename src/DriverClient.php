<?php

namespace Fairway\FairwayFilesystemApi;

use Stringable;

interface DriverClient extends Filesystem
{
    public function hasAssetPicker(): bool;

    public function getAssetPicker(): string;

    public function getFile(string|Stringable $identifier): File;

    public function getMetadata(string|Stringable $identifier): array;
}
