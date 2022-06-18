<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\block\Block;
use Core\drop\DropManager;

class DropCobblexInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9DROP");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        
        $cx = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK, 0, 32);
        $cx1 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD_BLOCK, 0, 32);
        $cx2 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_BLOCK, 0, 25);
        $cx3 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BLOCK, 0, 42);
        $cx4 = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 22);
        $cx5 = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 10);


        $this->setItemAt(1, 1, $cx);
        $this->setItemAt(2, 1, $cx1);
        $this->setItemAt(3, 1, $cx2);
        $this->setItemAt(4, 1, $cx3);
        $this->setItemAt(5, 1, $cx4);
        $this->setItemAt(6, 1, $cx5);




    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;

        return true;
    }
}