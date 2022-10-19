<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi\Adapter\CantoAdapter;

use DateTime;
use Fairway\FairwayFilesystemApi\File;

final class CantoFile extends File
{
    public function getFileName(): string
    {
        return $this->getMetadata()['default']['Name'];
    }

    public function getCantoIdentifier(): CantoIdentifier
    {
        return new CantoIdentifier($this->identifier);
    }

    public function getScheme(): string
    {
        return $this->getCantoIdentifier()->getScheme();
    }

    public function getIdentifier(): string
    {
        return $this->getCantoIdentifier()->getIdentifier();
    }

    public function getPublicUrl(): string
    {
        return '';
    }

    /**
     * does not have last access time, thus setting it to last modified time
     */
    public function getATime(): int
    {
        return $this->getMTime();
    }

    public function getMTime(): int
    {
        return DateTime::createFromFormat(
            'YmdHisv',
            $this->getMetadata()['default']['Date modified']
        )->getTimestamp();
    }

    public function getCTime(): int
    {
        return DateTime::createFromFormat(
            'YmdHisv',
            $this->getMetadata()['default']['Date uploaded']
        )->getTimestamp();
    }

    public function getExtension(): string
    {
        return $this->getMetadata()['metadata']['File Type Extension'];
    }
}
