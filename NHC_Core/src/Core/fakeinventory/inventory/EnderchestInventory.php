<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;
use Core\user\SaveInventory;

class EnderchestInventory extends FakeInventory {
    use SaveInventory;

    public static $inv = [];
    

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§bENDERCHEST", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        if($this->getInventoryContents($player, "{$player->getName()}") == null) {

        } else {
            $this->setContents($this->getInventoryContents($player, "{$player->getName()}"));

        }

        self::$inv = $this->getContents();

        //$player->getInventory()->setContents($this->getInventoryContents($player, "{$player->getName()}"));
        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $this->removeEnderInventory($player, $player->getName());
        $this->saveEnderInventory($player, $player->getName());

        return false;
    }
}