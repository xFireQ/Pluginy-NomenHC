<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender
};

use Core\command\BaseCommand;

use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;
use Core\form\DropForm;
use pocketmine\Server;

use Core\fakeinventory\inventory\BackupInventory;
use Core\user\SaveInventory;
use Core\Main;

class BackupCommand extends BaseCommand {
    use SaveInventory;

    public function __construct() {
        parent::__construct("backup", "komenda backup", [], true, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

        if(empty($args)) {
            $sender->sendMessage("§7Poprawne uzycie to: §l§b/backup nick");
            return;
        }

        if(isset($args[0])) {
            $player = Server::getInstance()->getPlayer($args[0]);
            $args = $args[0];
            $name = $player == null ? $args[0] : $player->getName();
            $inventory_names = $this->getAllInventoryNames($player);

            (new BackupInventory($player, $inventory_names, $name, $args))->openFor($sender);
        }

    }


}