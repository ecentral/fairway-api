<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi;

abstract class Directory
{
    abstract public function getIdentifier(): string;

    abstract public function getFileName(): string;

    abstract public function getATime(): int;

    abstract public function getMTime(): int;

    abstract public function getCTime(): int;

    abstract public function getParentDirectory(): Directory;
}
