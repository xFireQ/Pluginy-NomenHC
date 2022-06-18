<?php

namespace Core\fakeinventory;

use pocketmine\player\Player;

class InventoryPlayer extends Player {

    public function getOpenedWindows() : array {
        return $this->windowIndex;
    }
}