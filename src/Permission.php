<?php

declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi;

use JetBrains\PhpStorm\ArrayShape;
use Stringable;

abstract class Permission
{
    /**
     * todo: refactor as enum
     */
    public const ACTION_CREATE_FILE = 'create_file';
    public const ACTION_CREATE_FOLDER = 'create_folder';
    public const ACTION_UPDATE_FILE = 'update_file';
    public const ACTION_UPDATE_FOLDER = 'update_folder';
    public const ACTION_COPY_FILE = 'copy_file';
    public const ACTION_COPY_FOLDER = 'copy_folder';
    public const ACTION_MOVE_FILE = 'move_file';
    public const ACTION_MOVE_FOLDER = 'move_folder';
    public const ACTION_DELETE_FILE = 'delete_file';
    public const ACTION_DELETE_FOLDER = 'delete_folder';

    public function __construct(
        protected readonly string|Stringable $identifier,
        protected readonly bool $read = false,
        protected readonly bool $write = false,
    )
    {
    }

    public function canRead(): bool
    {
        return $this->read;
    }

    public function canWrite(): bool
    {
        return $this->write;
    }

    abstract public function hasPermission(string $action): bool;

    #[ArrayShape(['r' => "bool", 'w' => "bool"])]
    public function __toArray(): array
    {
        return [
            'r' => $this->read,
            'w' => $this->write,
        ];
    }
}