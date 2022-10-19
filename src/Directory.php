<?php

declare(strict_types=1);

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

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
