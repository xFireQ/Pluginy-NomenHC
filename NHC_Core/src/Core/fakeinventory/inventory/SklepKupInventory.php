<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\managers\SklepManager;
use pocketmine\block\Block;
use Core\Main;

class SklepKupInventory extends FakeInventory {

    public function __construct(Player $player) {
        $nick = $player->getName();
        $m = SklepManager::getMonety($nick);
        parent::__construct($player,"§r§l§9SKLEP", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $money = SklepManager::getMonety($nick);
        $stoneMoney = $money - 0.99;

        if($money >= 0.99) {
             $stoneMsg = "§r§8» §7Po zakupie pozostanie §9{$stoneMoney} monet§7!";
        } else {
             $stoneMsg = "§r§8» §7Nie mozesz zakupic tego itemu!";
        }
        
        
        
        $stone = \pocketmine\item\ItemFactory::getInstance()->get(1, 0, 1);
        $stone->setCustomName("§r§9STONE");
        $stone->setLore(["§r§8» §7Koszt tego itemu: §90.99",
        "§r{$stoneMsg}",
        "§r§8» §7Aktualny stan konta wynosi: §9{$money} monet§7!",
        "§r§8» §7Kliknij §9LPM §7aby zakupic!"]);
        
        $back = \pocketmine\item\ItemFactory::getInstance()->get(399, 0, 1);
        $back->setCustomName("§r§8» §l§9Cofnij");
        $this->setItemAt(9, 6, $back);
        
        $this->setItemAt(2, 2, $stone);
        
     

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;

        $nick = $player->getName();
        $money = SklepManager::getMonety($nick);
        if($item->getId() == "1") {
            //$this->openFakeInventory($player, new DropStoneInventory($player));
            if(SklepManager::getMonety($nick) >= 0.99) {
                $m = 0.99;
                SklepManager::removeMonety($nick, $m);
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten item pozostalo: §9$money"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE, 0, 64));
                $this->setItems($player);
                $this->unClickItem($player);
            } else {
                $player->sendMessage(Main::format("Nie posiadasz monet aby zakupic ten item!"));
            }
            
        }
        
        if($item->getId() === 399) {
             $this->openFakeInventory($player, new SklepInventory($player));
        }
        
        return true;
    }
}