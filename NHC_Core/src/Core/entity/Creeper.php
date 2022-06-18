<?php

namespace Core\entity;

use pocketmine\entity\Entity;
use pocketmine\entity\Monster;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;

class Creeper extends Monster {
    public const NETWORK_ID = self::CREEPER;

    public $width = 0.6;
    public $height = 1.8;

    public function getName() : string{
        return "Creeper";
    }

    public function getDrops() : array{
        $drops = [
            ItemFactory::get(ItemIds::TNT, 0, mt_rand(0, 2))
        ];

        return $drops;
    }

    public function getXpDropAmount() : int{
        return 30;
    }

    /**
     * @param float $height
     */
    public function setHeight(float $height): void {
        $this->height = $height;
    }


}