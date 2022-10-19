<?php

namespace Fairway\FairwayFilesystemApi\Adapter\PixelboxxAdapter;

use Fairway\FairwayFilesystemApi\Permission;
use Fairway\PixelboxxSaasApi\PixelboxxResourceName;

final class PixelboxxPermission extends Permission
{
    public function hasPermission(string $action): bool
    {
        $prn = new PixelboxxResourceName($this->identifier);
        if ($prn->getResourceType() === PixelboxxResourceName::ASSET) {
            return [
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
            ][$action] ?? false;
        }
        if ($prn->getResourceType() === PixelboxxResourceName::FOLDER) {
            return [
                Permission::ACTION_CREATE_FILE => true,
                Permission::ACTION_UPDATE_FILE => true,
                Permission::ACTION_COPY_FILE => true,
                Permission::ACTION_MOVE_FILE => true,
                Permission::ACTION_DELETE_FILE => true,
                Permission::ACTION_CREATE_FOLDER => true,
                Permission::ACTION_UPDATE_FOLDER => true,
                Permission::ACTION_COPY_FOLDER => true,
                Permission::ACTION_MOVE_FOLDER => true,
                Permission::ACTION_DELETE_FOLDER => true,
            ][$action] ?? false;
        }
        return false;
    }
}
