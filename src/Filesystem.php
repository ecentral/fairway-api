<?php

namespace Fairway\FairwayFilesystemApi;

interface Filesystem
{
    public function exists(string $identifier, string $type): bool;

    public function getType(string $identifier): string;

    public function read(string $identifier): string;

    public function listDirectory(string $identifier = null): DirectoryIterator;

    public function lastModified(string $identifier): int;

    public function size(string $identifier): int;

    public function count(string $identifier): int;

    public function mimeType(string $identifier): string;

    public function visibility(string $identifier): string;

    public function getPermission(string $identifier): Permission;

    public function write(string $identifier, string $parentIdentifier, string $filePath, array $config = []): string;

    public function setVisibility(string $identifier): void;

    public function delete(string $identifier): void;

    public function create(string $identifier, string $parentIdentifier, array $config = []): string;

    public function move(string $identifier, string $oldDestination, string $destination, array $config = []): void;

    public function copy(string $identifier, string $destination, array $config = []): void;

    public function rename(string $identifier, string $newName, array $config = []): void;

    public function replace(string $identifier, string $filePath, array $config = []): string;

    public function parentOfIdentifier(string $identifier);

    public function getDriver(): DriverClient;
}
