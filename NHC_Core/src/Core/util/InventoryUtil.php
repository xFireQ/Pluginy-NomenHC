<?php

declare(strict_types=1);

namespace Core\util;

use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\world\Position;
use pocketmine\math\Vector3;

class InventoryUtil {

    public static function addItem(Inventory $inventory, Position $position, Item $item) : void {
        $inventory->canAddItem($item) ? $inventory->addItem($item) : $position->getWorld()->dropItem($position, $item);
    }
}