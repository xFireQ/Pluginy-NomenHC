<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;

class DropMenuInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9DROP");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        
        $cx = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOSS_STONE);
        $cx->setCustomName("§r§9DROP Z COBBLEX");
        $stone = \pocketmine\item\ItemFactory::getInstance()->get(278, 0, 1);
        $stone->setCustomName("§r§9DROP ZE STONE");
        
        $pc = \pocketmine\item\ItemFactory::getInstance()->get(122, 0, 1);
        $pc->setCustomName("§r§9DROP Z PANDOR §8(§9PremiumCase§8)");
        
        $this->setItemAt(3, 2, $cx);
        $this->setItemAt(5, 2, $stone);
        $this->setItemAt(7, 2, $pc);
     

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        if($item->getId() == "278") {
            $this->changeInventory($player, (new DropStoneInventory($player)));
        }

        if($item->getId() == "48") {
            $this->changeInventory($player, (new DropCobblexInventory($player)));
        }
        
        if($item->getId() == "122") {
            $this->changeInventory($player, (new DropCaseInventory($player)));
        }
        return true;
    }
}