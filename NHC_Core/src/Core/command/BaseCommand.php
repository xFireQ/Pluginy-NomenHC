<?php

declare(strict_types=1);

namespace Core\command;

use Core\format\Permission;
use Core\util\ChatUtil;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\Player;
use Core\Main;

abstract class BaseCommand extends Command {

      private $playerCommand;

    public function __construct(string $name, string $description, array $aliases = [], bool $playerCommand = false, bool $permission = false) {
        parent::__construct($name, $description, null, $aliases);

        $this->playerCommand = $playerCommand;

        if($permission)
            Permission::setPermission("NomenHC.". $name .".command");
    }

    public function execute(CommandSender $sender, string $label, array $args) : void {
        if($this->playerCommand && !$sender instanceof Player) {
            $sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
            return;
        }

        $permission = $this->getPermission();

        if($permission !== null && !Permission::has($sender, $permission)) {
            $sender->sendMessage(Main::format("Nie posiadasz permisji aby uzyc ta komende §8[§9{$permission}§8]"));
            $sender->sendTitle("§l§9Permisja", "§7PERMISJA §8[§9{$permission}§8]");
            return;
        }

        $this->onCommand($sender, $args);
    }

    abstract public function onCommand(CommandSender $sender, array $args) : void;
}