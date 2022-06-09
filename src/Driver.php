<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi;

use ReturnTypeWillChange;
use Stringable;

class Driver implements Filesystem
{
    public function __construct(
        private readonly DriverClient $driverClient,
        private readonly Config $config = new Config()
    ) {
    }

    public function exists(string|Stringable $identifier, FileType $type): bool
    {
        return $this->driverClient->exists($identifier, $type);
    }

    public function directoryExists(string $identifier): bool
    {
        return $this->exists($identifier, FileType::Directory);
    }

    public function fileExists(string $identifier): bool
    {
        return $this->exists($identifier, FileType::File);
    }

    public function getType(string|Stringable $identifier): FileType
    {
        return $this->driverClient->getType($identifier);
    }

    public function isDirectory(string $identifier): bool
    {
        return $this->getType($identifier) === FileType::Directory;
    }

    public function isFile(string $identifier): bool
    {
        return $this->getType($identifier) === FileType::File;
    }

    public function read(string|Stringable $identifier): string
    {
        return $this->driverClient->read($identifier);
    }

    public function listDirectory(string|Stringable $identifier): DirectoryIterator
    {
        return $this->driverClient->listDirectory($identifier);
    }

    public function lastModified(string|Stringable $identifier): int
    {
        return $this->driverClient->lastModified($identifier);
    }

    public function size(string|Stringable $identifier): int
    {
        return $this->driverClient->size($identifier);
    }

    public function count(string|Stringable $identifier): int
    {
        return $this->driverClient->count($identifier);
    }

    public function mimeType(string|Stringable $identifier): string
    {
        return $this->driverClient->mimeType($identifier);
    }

    public function visibility(string|Stringable $identifier): string
    {
        return $this->driverClient->visibility($identifier);
    }

    #[ReturnTypeWillChange]
    public function getPermission(string|Stringable $identifier): Permission
    {
        return $this->driverClient->getPermission($identifier);
    }

    public function write(string|Stringable $identifier, string|Stringable $parentIdentifier, string $filePath, array $config = []): string
    {
        $this->driverClient->write($identifier, $parentIdentifier, $filePath, $config);
    }

    public function setVisibility(string|Stringable $identifier): void
    {
        $this->driverClient->setVisibility($identifier);
    }

    public function delete(string|Stringable $identifier): void
    {
        $this->driverClient->delete($identifier);
    }

    public function create(string|Stringable $identifier, string|Stringable $parentIdentifier, array $config = []): string
    {
        $this->driverClient->create($identifier, $parentIdentifier, $this->config->toArray($config));
    }

    public function move(string|Stringable $identifier, string $oldDestination, string $destination, array $config = []): void
    {
        $this->driverClient->move($identifier, $oldDestination, $destination, $this->config->toArray($config));
    }

    public function copy(string|Stringable $identifier, string $destination, array $config = []): void
    {
        $this->driverClient->copy($identifier, $destination, $this->config->toArray($config));
    }

    public function getAdapter(): DriverClient
    {
        return $this->driverClient;
    }

    public function rename(Stringable|string $identifier, string $newName, array $config = []): void
    {
        $this->driverClient->rename($identifier, $newName, $config);
    }

    public function replace(Stringable|string $identifier, string $filePath, array $config = []): string
    {
        return $this->driverClient->replace($identifier, $filePath, $config);
    }

    public function parentOfIdentifier(Stringable|string $identifier): Directory
    {
        return $this->driverClient->parentOfIdentifier($identifier);
    }

    public function getDriver(): DriverClient
    {
        return $this->driverClient;
    }
}
