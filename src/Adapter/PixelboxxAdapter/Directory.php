<?php

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;

use Fairway\PixelboxxSaasApi\Model\Folder;

final class Directory extends \Fairway\FairwayFilesystemApi\Directory
{
    private Folder $folder;
    private ?Directory $parent;

    public function __construct(Folder $folder, Directory $parent = null)
    {
        $this->folder = $folder;
        $this->parent = $parent;
    }

    public function getIdentifier(): string
    {
        if ($this->folder->getId()->getResourceId() === '0') {
            return '';
        }
        $parent = '';
        if ($this->parent) {
            $parent = $this->parent->getIdentifier();
        }
        return $parent . '/' . $this->folder->getId()->getResourceId();
    }

    public function getFileName(): string
    {
        return $this->folder->getName();
    }

    public function getATime(): int
    {
        return 0;
    }

    public function getMTime(): int
    {
        return 0;
    }

    public function getCTime(): int
    {
        return 0;
    }

    public function getParentDirectory(): self
    {
        return $this->parent;
    }
}
