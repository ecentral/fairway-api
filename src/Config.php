<?php

declare(strict_types=1);

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi;

final class Config
{
    public function __construct()
    {
    }

    public function toArray(array $mergeWith = []): array
    {
        return array_merge([], $mergeWith);
    }
}
