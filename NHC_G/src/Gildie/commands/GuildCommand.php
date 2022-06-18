<?php

declare(strict_types=1);

namespace Gildie\commands;

use Gildie\permission\Permission;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use LightPE_Core\Main;

abstract class GuildCommand extends Command {

    private $seePermission;
    private $usePermission = null;

    public function __construct(string $name, string $description, bool $usePerm = false, array $aliases= []) {
        $this->seePermission = $seePerm = "NomenHC.command.see";
        Permission::setPermission($seePerm);

        if($usePerm)
            $this->usePermission = "NomenHC.command.".$name;

        parent::__construct($name, $description, null, $aliases);
    }

    public function getSeePermission() : string {
        return $this->seePermission;
    }

    public function getUsePermission() : ?string {
        return $this->usePermission;
    }

    public function canUse(CommandSender $sender) : bool {
        if($this->usePermission == null)
            return true;
        else {
            if(!Permission::has($sender, $this->usePermission)) {
                $sender->sendMessage(Main::format("§cNie posiadasz permisji aby uzyc ta komende!"));
                return false;
            }
            return true;
        }
    }
}