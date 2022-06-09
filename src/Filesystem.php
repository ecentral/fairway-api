<?php

namespace Fairway\FairwayFilesystemApi;

use Stringable;

interface Filesystem
{
    public function exists(string|Stringable $identifier, FileType $type): bool;

    public function getType(string|Stringable $identifier): FileType;

    public function read(string|Stringable $identifier): string;

    public function listDirectory(string|Stringable $identifier): DirectoryIterator;

    public function lastModified(string|Stringable $identifier): int;

    public function size(string|Stringable $identifier): int;

    public function count(string|Stringable $identifier): int;

    public function mimeType(string|Stringable $identifier): string;

    public function visibility(string|Stringable $identifier): string;

    public function getPermission(string|Stringable $identifier): Permission;

    public function write(string|Stringable $identifier, string|Stringable $parentIdentifier, string $filePath, array $config = []): string;

    public function setVisibility(string|Stringable $identifier): void;

    public function delete(string|Stringable $identifier): void;

    public function create(string|Stringable $identifier, string|Stringable $parentIdentifier, array $config = []): string;

    public function move(string|Stringable $identifier, string $oldDestination, string $destination, array $config = []): void;

    public function copy(string|Stringable $identifier, string $destination, array $config = []): void;

    public function rename(string|Stringable $identifier, string $newName, array $config = []): void;

    public function replace(string|Stringable $identifier, string $filePath, array $config = []): string;

    public function parentOfIdentifier(string|Stringable $identifier): Directory;

    public function getDriver(): DriverClient;
}
