<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender};
use Gildie\fakeinventory\GuildItemsInventory;

use Gildie\fakeinventory\inventory\PanelInventory;

class PanelCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("panel", "Komenda panel");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;
            
        
            
        $gui = new PanelInventory($sender);
        $gui->setItems($sender);
        $gui->openFor($sender);
    }
}