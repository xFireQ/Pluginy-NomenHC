<?php

declare(strict_types=1);

namespace Core\crafting;

use pocketmine\item\Item;

class CraftingRecipe {

    private $items;
    private $result;

    public function __construct(array $items, Item $result) {
        $this->items = $items;
        $this->result = $result;
    }

    /**
     * @return Item[]
     */
    public function getItems() : array {
        return $this->items;
    }

    public function getResult() : Item {
        return $this->result;
    }
}