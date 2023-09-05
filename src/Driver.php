<?php

declare(strict_types=1);

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi;

class Driver implements Filesystem
{
    protected DriverClient $driverClient;
    protected Config $config;

    public function __construct(
        DriverClient $driverClient,
        Config $config = null
    ) {
        $this->driverClient = $driverClient;
        $this->config = $config ?? new Config();
    }

    public function exists(string $identifier, string $type): bool
    {
        return $this->driverClient->exists($identifier, $type);
    }

    public function directoryExists(string $identifier): bool
    {
        return $this->exists($identifier, FileType::DIRECTORY);
    }

    public function fileExists(string $identifier): bool
    {
        return $this->exists($identifier, FileType::FILE);
    }

    public function getType(string $identifier): string
    {
        return $this->driverClient->getType($identifier);
    }

    public function isDirectory(string $identifier): bool
    {
        return $this->getType($identifier) === FileType::DIRECTORY;
    }

    public function isFile(string $identifier): bool
    {
        return $this->getType($identifier) === FileType::FILE;
    }

    public function read(string $identifier): string
    {
        return $this->driverClient->read($identifier);
    }

    public function listDirectory(string $identifier = null): DirectoryIterator
    {
        return $this->driverClient->listDirectory($identifier);
    }

    public function lastModified(string $identifier): int
    {
        return $this->driverClient->lastModified($identifier);
    }

    public function size(string $identifier): int
    {
        return $this->driverClient->size($identifier);
    }

    public function count(string $identifier): int
    {
        return $this->driverClient->count($identifier);
    }

    public function mimeType(string $identifier): string
    {
        return $this->driverClient->mimeType($identifier);
    }

    public function visibility(string $identifier): string
    {
        return $this->driverClient->visibility($identifier);
    }

    public function getPermission(string $identifier): Permission
    {
        return $this->driverClient->getPermission($identifier);
    }

    public function write(string $identifier, string $parentIdentifier, string $filePath, array $config = []): string
    {
        return $this->driverClient->write($identifier, $parentIdentifier, $filePath, $config);
    }

    public function setVisibility(string $identifier): void
    {
        $this->driverClient->setVisibility($identifier);
    }

    public function delete(string $identifier): void
    {
        $this->driverClient->delete($identifier);
    }

    public function create(string $identifier, string $parentIdentifier, array $config = []): string
    {
        return $this->driverClient->create($identifier, $parentIdentifier, $this->config->toArray($config));
    }

    public function move(string $identifier, string $oldDestination, string $destination, array $config = []): void
    {
        $this->driverClient->move($identifier, $oldDestination, $destination, $this->config->toArray($config));
    }

    public function copy(string $identifier, string $destination, array $config = []): void
    {
        $this->driverClient->copy($identifier, $destination, $this->config->toArray($config));
    }

    public function getAdapter(): DriverClient
    {
        return $this->driverClient;
    }

    public function rename(string $identifier, string $newName, array $config = []): void
    {
        $this->driverClient->rename($identifier, $newName, $config);
    }

    public function replace(string $identifier, string $filePath, array $config = []): string
    {
        return $this->driverClient->replace($identifier, $filePath, $config);
    }

    public function parentOfIdentifier(string $identifier): Directory
    {
        return $this->driverClient->parentOfIdentifier($identifier);
    }

    public function getDriver(): DriverClient
    {
        return $this->driverClient;
    }
}
