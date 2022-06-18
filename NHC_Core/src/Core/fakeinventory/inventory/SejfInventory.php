<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\nbt\NBT;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\player\Player;

class SejfInventory extends FakeInventory {

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9SEJF", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {


        return false;
    }

}