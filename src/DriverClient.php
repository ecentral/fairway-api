<?php

namespace Fairway\FairwayFilesystemApi;

interface DriverClient extends Filesystem
{
    public function hasAssetPicker(): bool;

    public function getAssetPicker(): string;

    public function getFile(string $identifier): File;

    public function getMetadata(string $identifier): array;
}
