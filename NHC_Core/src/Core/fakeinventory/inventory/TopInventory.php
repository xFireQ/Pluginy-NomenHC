<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use Core\user\UserManager;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\Main;

class TopInventory extends FakeInventory {

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9TOP");
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $array = UserManager::topPoinst();
        $this->clearAll();
        $item = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1)->setCustomName("§r§l§9TOP PUNKTY");

        /*foreach (array_slice($array, 0, 10) as $name => $points) {
            $item = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1)->setCustomName("§r§l§9TOP PUNKTY")->setLore([
                "§r§7Nick: §9".$name."§r §7punkty§r§7: §9".$points."§r\n"
            ]);
        }*/

        $this->setItemAt(5, 2, $item);


        $this->fill();


    }

    public function setItemsTop(Player $player) : void {
        $nick = $player->getName();
        $this->clearAll();
        $array = UserManager::topPoinst();
        $item = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1)->setCustomName("§r§l§9TOP PUNKTY");
        $i = 0;

        foreach (array_slice($array, 0, 10) as $name => $points) {
            $item = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1)->setCustomName("§r§l§7Gracz: §9".$name)->setLore([
                "§r§l§7Punkty§r§7: §9".$points."§r\n"
            ]);
            $this->setItem($i, $item);
            $i++;
        }



        $this->fill();


    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        if($sourceItem->getId() === 276) {
            $this->setItemsTop($player);
        }
        return true;
    }


}