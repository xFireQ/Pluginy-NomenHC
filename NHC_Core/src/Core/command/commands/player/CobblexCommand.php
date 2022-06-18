<?php

namespace Core\command\commands\player;

use pocketmine\Server;

use pocketmine\command\{
    Command, CommandSender
};
use pocketmine\item\Item;
use pocketmine\block\Block;
use Core\Main;

use Core\command\BaseCommand;

class CobblexCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("cobblex", "Komenda cobblex", ["cx"], false);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $player = $sender;
        if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE, 0, 9*64))) {
            $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE, 0, 9*64));
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(48, 0, 1));
            $player->sendMessage(Main::format("Pomyslnie zakupiono cobblex"));
        } else {
            $player->sendMessage(Main::format("Nie posiadasz 9 stakow cobblestone!"));
        }
    }
}