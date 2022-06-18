<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender};
use Gildie\fakeinventory\GuildItemsInventory;

use Gildie\fakeinventory\inventory\ItemyInventory;

class ItemyCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("itemy", "Komenda itemy");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;
            
        $gui = new ItemyInventory($sender);
        $gui->setItems($sender);
        $gui->openFor([$sender]);
    }
}