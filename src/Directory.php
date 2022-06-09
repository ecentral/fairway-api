<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi;

/**
 * todo: give this class some love and filling
 */
abstract class Directory
{
    public function getIdentifier()
    {

    }

    abstract public function getFileName(): string;

    abstract public function getATime(): int;

    abstract public function getMTime(): int;

    abstract public function getCTime(): int;
}
