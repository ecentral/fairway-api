<?php

declare(strict_types=1);

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi;

use IteratorAggregate;
use Traversable;

class DirectoryIterator implements IteratorAggregate
{
    private iterable $directories;

    public function __construct(iterable $directories)
    {
        $this->directories = $directories;
    }

    public function getIterator(): Traversable
    {
        return $this->getGenerator();
    }

    public function map(callable $map): DirectoryIterator
    {
        return new self($this->getGenerator(null, $map));
    }

    public function filter(callable $filter): DirectoryIterator
    {
        return new self($this->getGenerator($filter));
    }

    private function getGenerator(callable $filter = null, callable $map = null): \Generator
    {
        return (function () use ($filter, $map) {
            foreach ($this->directories as $key => $value) {
                if ($filter !== null && !$filter($value)) {
                    continue;
                }
                if ($map !== null) {
                    $value = $map($value);
                }
                yield $key => $value;
            }
        })();
    }

    public function toArray(): array
    {
        if ($this->directories instanceof Traversable) {
            return iterator_to_array($this->directories, false);
        }
        return (array)$this->directories;
    }

    public function count(): int
    {
        return count($this->toArray());
    }
}
