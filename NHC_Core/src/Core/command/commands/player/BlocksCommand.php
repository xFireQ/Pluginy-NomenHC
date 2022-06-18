<?php

namespace Core\command\commands\player;

use Core\fakeinventory\inventory\BlocksInventory;
use Core\fakeinventory\inventory\CraftingiInventory;
use pocketmine\command\CommandSender;
use Core\command\BaseCommand;

class BlocksCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("bloki", "Komenda bloki", ["blok", "blocks"], true);

    }

    public function onCommand(CommandSender $sender, array $args) : void {
        (new BlocksInventory($sender))->openFor([$sender]);
    }
}