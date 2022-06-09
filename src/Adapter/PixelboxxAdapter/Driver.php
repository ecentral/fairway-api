<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;

use Fairway\FairwayFilesystemApi\DirectoryIterator;
use Fairway\FairwayFilesystemApi\DriverClient;
use Fairway\FairwayFilesystemApi\File;
use Fairway\FairwayFilesystemApi\FileType;
use Fairway\FairwayFilesystemApi\Permission;
use ReturnTypeWillChange;
use Stringable;

final class Driver implements DriverClient
{
    public function hasAssetPicker(): bool
    {
        return true;
    }

    public function getAssetPicker(): string
    {
        return '';
    }

    public function getFile(string|Stringable $identifier): File
    {
        return new File($this, $identifier);
    }

    public function getMetadata(string|Stringable $identifier): array
    {
        return [];
    }

    public function exists(string|Stringable $identifier, FileType $type): bool
    {
        return false;
    }

    public function getType(string|Stringable $identifier): FileType
    {
        return FileType::File;
    }

    public function read(string|Stringable $identifier): string
    {
        return '';
    }

    public function listDirectory(string|Stringable $identifier): DirectoryIterator
    {
        // TODO: Implement listDirectory() method.
    }

    public function lastModified(string|Stringable $identifier): int
    {
        return 0;
    }

    public function size(string|Stringable $identifier): int
    {
        return 0;
    }

    public function count(string|Stringable $identifier): int
    {
        return $this->listDirectory($identifier)->count();
    }

    public function mimeType(string|Stringable $identifier): string
    {
        return '';
    }

    public function visibility(string|Stringable $identifier): string
    {
        return '';
    }

    #[ReturnTypeWillChange] public function getPermission(string|Stringable $identifier): Permission
    {
        return null;
    }

    public function write(string|Stringable $identifier, string|Stringable $parentIdentifier, string $filePath, array $config = []): string
    {
        // TODO: Implement write() method.
    }

    public function setVisibility(string|Stringable $identifier): void
    {
        // TODO: Implement setVisibility() method.
    }

    public function delete(string|Stringable $identifier): void
    {
        // TODO: Implement delete() method.
    }

    public function create(string|Stringable $identifier, string|Stringable $parentIdentifier, array $config = []): string
    {
        // TODO: Implement create() method.
    }

    public function move(string|Stringable $identifier, string $oldDestination, string $destination, array $config = []): void
    {
        // TODO: Implement move() method.
    }

    public function copy(string|Stringable $identifier, string $destination, array $config = []): void
    {
        // TODO: Implement copy() method.
    }
}
