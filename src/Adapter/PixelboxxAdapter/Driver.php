<?php

declare(strict_types=1);

/*
 * This file is part of the "fairway_api" library by eCentral GmbH.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;

use Exception;
use Fairway\FairwayFilesystemApi\DirectoryIterator;
use Fairway\FairwayFilesystemApi\DriverClient;
use Fairway\FairwayFilesystemApi\Exceptions\NotImplementedException;
use Fairway\FairwayFilesystemApi\Exceptions\NotSupportedException;
use Fairway\FairwayFilesystemApi\File;
use Fairway\FairwayFilesystemApi\FileType;
use Fairway\FairwayFilesystemApi\Permission;
use Fairway\PixelboxxSaasApi\Client;
use Fairway\PixelboxxSaasApi\Model\Folder;
use Fairway\PixelboxxSaasApi\Model\MetadataGroup;
use Fairway\PixelboxxSaasApi\PixelboxxResourceName;
use Fairway\PixelboxxSaasApi\Request\Assets\AssetMetadata;
use Fairway\PixelboxxSaasApi\Utility\PixelboxxUtility;

final class Driver implements DriverClient
{
    private Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function hasAssetPicker(): bool
    {
        return true;
    }

    public function getAssetPicker(): string
    {
        throw new NotImplementedException();
    }

    public function getFile(string $identifier): File
    {
        return new PixelboxxFile($this, $identifier);
    }

    public function getPublicUrl(string $identifier): string
    {
        return $this->client->assets()->getThumbnail($identifier)->getUrl();
    }

    public function getMetadata(string $identifier): array
    {
        if ($this->getType($identifier) === FileType::DIRECTORY) {
            throw new NotSupportedException();
        }
        /** @var MetadataGroup[] $metadataGroups */
        $metadataGroups = $this->client->assets()->getAsset($identifier, function (AssetMetadata $metadata) {
            $metadata->setFull(true);
            $metadata->setAllMeta(true);
        })->getAsset()->getMetadata();
        $metadata = [];
        foreach ($metadataGroups as $metadataGroup) {
            foreach ($metadataGroup->getProperties() as $property) {
                // todo: There should be a metadata model
                $metadata[] = $property;
            }
        }
        return $metadata;
    }

    public function exists(string $identifier, string $type): bool
    {
        if ($type === FileType::FILE) {
            return $this->client->assets()->getAsset($identifier) !== null;
        }
        return $this->client->folders()->getFolderAssets($identifier) !== null;
    }

    public function getType(string $identifier): string
    {
        try {
            $identifier = new PixelboxxResourceName($identifier);
        } catch (Exception $exception) {
            throw new NotSupportedException('Identifier is not supported');
        }
        if ($identifier->getResourceType() === PixelboxxResourceName::FOLDER) {
            return FileType::DIRECTORY;
        }
        if ($identifier->getResourceType() === PixelboxxResourceName::ASSET) {
            return FileType::FILE;
        }
        throw new NotSupportedException(sprintf('File-Type %s is not supported', $identifier->getResourceType()));
    }

    public function read(string $identifier): string
    {
        return $this->client->assets()->downloadAsset($identifier)->getContent();
    }

    public function listDirectory(string $identifier = null, bool $recursive = false): DirectoryIterator
    {
        $structure = $this->client->folders()->getFolderStructure($identifier);
        $directories = [];
        if ($structure !== null) {
            $this->flattenDirectoryStructure($structure->getFolder(), $directories, null, $recursive);
        }
        return new DirectoryIterator($directories);
    }

    public function getDirectory(string $identifier = null): ?Directory
    {
        $folder = $this->client->folders()->getFolderStructure($identifier);
        if ($folder === null) {
            return null;
        }
        return new Directory($folder->getFolder());
    }

    private function flattenDirectoryStructure(Folder $folder, array &$directories, Directory $parent = null, bool $recursive = false): void
    {
        $parentDirectory = new Directory($folder, $parent);
        foreach ($folder->getChildFolders() as $childFolder) {
            $directories[] = new Directory($childFolder, $parentDirectory);
            if ($recursive) {
                $this->flattenDirectoryStructure($childFolder, $directories, $parentDirectory, $recursive);
            }
        }
    }

    public function lastModified(string $identifier): int
    {
        $metadata = $this->client->assets()->getAsset($identifier)->getAsset()->getMetadataByPropertyId('versiondate');
        return PixelboxxUtility::buildTimestamp($metadata->getValue());
    }

    public function size(string $identifier): int
    {
        $metadata = $this->client->assets()->getAsset($identifier)->getAsset()->getMetadataByPropertyId('filesize');
        return (int)$metadata->getValue();
    }

    public function count(string $identifier): int
    {
        if ($this->getType($identifier) === FileType::FILE) {
            throw new NotSupportedException('The type File cannot be counted');
        }
        $folder = $this->client->folders()->getFolderStructure($identifier);
        return $folder === null ? 0 : $folder->getCount();
    }

    public function mimeType(string $identifier): string
    {
        $metadata = $this->client->assets()->getAsset($identifier)->getAsset()->getMetadataByPropertyId('type');
        return $metadata->getValue();
    }

    public function visibility(string $identifier): string
    {
        // todo: this needs to be refined, how are we going to implement visibility
        return '';
    }

    public function getPermission(string $identifier): Permission
    {
        return new PixelboxxPermission($identifier, true, true);
    }

    public function write(string $identifier, string $parentIdentifier, string $filePath, array $config = []): string
    {
        throw new NotImplementedException();
    }

    public function setVisibility(string $identifier): void
    {
        throw new NotImplementedException();
    }

    public function delete(string $identifier): void
    {
        throw new NotImplementedException();
    }

    public function create(string $identifier, string $parentIdentifier, array $config = []): string
    {
        throw new NotImplementedException();
    }

    public function move(string $identifier, string $oldDestination, string $destination, array $config = []): void
    {
        throw new NotImplementedException();
    }

    public function copy(string $identifier, string $destination, array $config = []): void
    {
        throw new NotImplementedException();
    }

    public function rename(string $identifier, string $newName, array $config = []): void
    {
        throw new NotImplementedException();
    }

    public function replace(string $identifier, string $filePath, array $config = []): string
    {
        throw new NotImplementedException();
    }

    public function parentOfIdentifier(string $identifier): DirectoryIterator
    {
        $file = $this->getClient()->assets()->getAsset($identifier)->getAsset();
        $directories = [];
        foreach ($file->getContainingFolders() as $parentFolder) {
            $directories[] = $this->getDirectory((string)$parentFolder);
        }
        return new DirectoryIterator($directories);
    }

    public function getDriver(): DriverClient
    {
        return $this;
    }
}
