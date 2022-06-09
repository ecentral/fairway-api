<?php

declare(strict_types=1);

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
