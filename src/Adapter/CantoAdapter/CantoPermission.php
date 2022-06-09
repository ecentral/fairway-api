<?php
declare(strict_types=1);

namespace Fairway\FairwayFilesystemApi\Adapter\CantoAdapter;


use Fairway\CantoSaasApi\Http\LibraryTree\GetDetailsRequest;
use Fairway\FairwayFilesystemApi\Permission;
use Stringable;

final class CantoPermission extends Permission
{
    public function hasPermission(string $action): bool
    {
        $cantoId = $this->parseIdentifier($this->identifier);
        $type = 'file';
        if (in_array($cantoId->getScheme(), [GetDetailsRequest::TYPE_ALBUM, GetDetailsRequest::TYPE_FOLDER], true)) {
            $type = $cantoId->getScheme();
        }
        return [
                GetDetailsRequest::TYPE_ALBUM => [
                    Permission::ACTION_CREATE_FILE => true,
                    Permission::ACTION_UPDATE_FILE => true,
                    Permission::ACTION_COPY_FILE => true,
                    Permission::ACTION_MOVE_FILE => true,
                    Permission::ACTION_DELETE_FILE => true,
                    Permission::ACTION_CREATE_FOLDER => false,
                    Permission::ACTION_UPDATE_FOLDER => false,
                    Permission::ACTION_COPY_FOLDER => false,
                    Permission::ACTION_MOVE_FOLDER => false,
                    Permission::ACTION_DELETE_FOLDER => false,
                ],
                GetDetailsRequest::TYPE_FOLDER => [
                    Permission::ACTION_CREATE_FILE => false,
                    Permission::ACTION_UPDATE_FILE => false,
                    Permission::ACTION_COPY_FILE => false,
                    Permission::ACTION_MOVE_FILE => false,
                    Permission::ACTION_DELETE_FILE => false,
                    Permission::ACTION_CREATE_FOLDER => true,
                    Permission::ACTION_UPDATE_FOLDER => true,
                    Permission::ACTION_COPY_FOLDER => false, // copying and moving of folders and albums not supported yet
                    Permission::ACTION_MOVE_FOLDER => false,
                    Permission::ACTION_DELETE_FOLDER => true,
                ],
                'file' => [
                    Permission::ACTION_CREATE_FILE => true,
                    Permission::ACTION_UPDATE_FILE => true,
                    Permission::ACTION_COPY_FILE => true,
                    Permission::ACTION_MOVE_FILE => true,
                    Permission::ACTION_DELETE_FILE => true,
                    Permission::ACTION_CREATE_FOLDER => false,
                    Permission::ACTION_UPDATE_FOLDER => false,
                    Permission::ACTION_COPY_FOLDER => false,
                    Permission::ACTION_MOVE_FOLDER => false,
                    Permission::ACTION_DELETE_FOLDER => false,
                ],
            ][$type][$action] ?? false;
    }

    private function parseIdentifier(string|Stringable $identifier): CantoIdentifier
    {
        if ($identifier instanceof CantoIdentifier) {
            return $identifier;
        }
        return new CantoIdentifier((string)$identifier);
    }
}
