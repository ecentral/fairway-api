<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi;

abstract class File
{
    private array $metadata = [];

    public DriverClient $client;
    public string $identifier;

    public function __construct(
        DriverClient $client,
        string $identifier
    )
    {
        $this->client = $client;
        $this->identifier = $identifier;
    }

    public function getMetadata(): array
    {
        if ($this->metadata === []) {
            $this->metadata = $this->client->getMetadata($this->identifier);
        }
        return $this->metadata;
    }

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getSize(): int
    {
        return $this->client->size($this->identifier);
    }

    public function getMimeType(): string
    {
        return $this->client->mimeType($this->identifier);
    }

    public function getParentOfIdentifier()
    {
        return $this->client->parentOfIdentifier($this->identifier);
    }

    public function getPermission(): Permission
    {
        return $this->client->getPermission($this->identifier);
    }

    abstract public function getPublicUrl(): string;

    abstract public function getFileName(): string;

    abstract public function getATime(): int;

    abstract public function getMTime(): int;

    abstract public function getCTime(): int;

    abstract public function getExtension(): string;
}
