<?php

namespace Core\command\commands\player;

use Core\fakeinventory\inventory\CraftingiInventory;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\command\utils\CommandException;
use pocketmine\player\Player;
use Core\command\BaseCommand;

class CraftingiCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("craftingi", "Komenda craftingi", ["ct", "crafting"], true);

    }

    public function onCommand(CommandSender $sender, array $args) : void {
        (new CraftingiInventory($sender))->openFor([$sender]);
    }
}