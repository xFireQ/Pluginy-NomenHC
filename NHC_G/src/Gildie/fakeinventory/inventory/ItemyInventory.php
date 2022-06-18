<?php

declare(strict_types=1);

namespace Gildie\fakeinventory\inventory;

use Gildie\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\block\Block;
use Gildie\Main;
use pocketmine\inventory\Inventory;

class ItemyInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player, "§l§9ITEMY NA GILDIE");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        
        //$item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK);
        $guildManager = Main::getInstance()->getGuildManager();
        $itemB = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS);
        $items = $guildManager->getItems($player);
        
        $i = 2;
        
        foreach ($items as $item) {
            $item->setCustomName("§r§8» §7" . $item->getName() . "§r§l§9 " . $this->getItemCount($player->getInventory(), $item) . "§r§8/§9§l" . $item->getCount());
            
        $this->setItemAt($i, 2, $item);
        $i++;
        }
        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        return true;
    }
    
    public function getItemCount(Inventory $inventory, Item $item) : int {
        $count = 0;

        foreach($inventory->getContents() as $i) {
            if($i->equals($item)) {
                $count += $i->getCount();
            }
        }

        return $count;
    }
}