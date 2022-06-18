<?php

namespace Core\format;

use pocketmine\command\CommandSender;
use pocketmine\permission\PermissionManager;
use pocketmine\permission\DefaultPermissions;

class Permission {

    public function __construct() {}

    public static function has(CommandSender $sender, string $permission) : bool {
        if($sender->hasPermission(DefaultPermissions::ROOT_OPERATOR) or $sender->hasPermission(DefaultPermissions::ROOT_CONSOLE)) {
            return true;
        }

        if(PermissionManager::getInstance()->getPermission($permission) === null) return false;

        return $sender->hasPermission($permission);
    }

    public static function isOp(CommandSender $sender) : bool {
        if($sender->hasPermission(DefaultPermissions::ROOT_OPERATOR) or $sender->hasPermission(DefaultPermissions::ROOT_CONSOLE)) {
            return true;
        }
        return false;
    }

    public static function setPermission(?string $permission): void {
        PermissionManager::getInstance()->addPermission(new \pocketmine\permission\Permission($permission, "Permission"));
    }


}