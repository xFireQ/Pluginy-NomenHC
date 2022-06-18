<?php

/*
 *     __						    _
 *    / /  _____   _____ _ __ _   _| |
 *   / /  / _ \ \ / / _ \ '__| | | | |
 *  / /__|  __/\ V /  __/ |  | |_| | |
 *  \____/\___| \_/ \___|_|   \__, |_|
 *						      |___/
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * @author LeverylTeam
 * @link https://github.com/LeverylTeam
 *
*/

declare(strict_types=1);

namespace Core\Block;

use pocketmine\block\utils\Fallable;
use pocketmine\entity\object\FallingBlock;
use pocketmine\item\Item;
use pocketmine\level\{Position, sound\GenericSound};
use pocketmine\math\Vector3;
use pocketmine\player\Player;

/**
 * Class DragonEgg
 * @package Xenophilicy\TableSpoon\block
 */
class DragonEgg extends FallingBlock {

    /** @var int $id */
    protected $id = self::DRAGON_EGG;

    /**
     * DragonEgg constructor.
     *
     * @param int $meta
     */
    public function __construct($meta = 0){
        $this->meta = $meta;
    }

    /**
     * @return string
     */
    public function getName(): string{
        return "Dragon Egg";
    }

    /**
     * @return float
     */
    public function getHardness(): float{
        return 4.5;
    }

    /**
     * @return float
     */
    public function getBlastResistance(): float{
        return 45;
    }

    /**
     * @return int
     */
    public function getLightLevel(): int{
        return 1;
    }

    /**
     * @param Item $item
     * @return bool
     */
    public function isBreakable(Item $item): bool{
        return false;
    }

    /**
     * @return bool
     */
    public function canBeActivated(): bool{
        return true;
    }
}
