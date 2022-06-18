<?php

declare(strict_types=1);

namespace Core\util;

use pocketmine\block\Block;
use pocketmine\level\Level;
use pocketmine\world\Position;
use pocketmine\math\Vector3;

class ShapesUtils {

    public static function createGuildShape(Position $heartPosition) : void {
        self::createAirCube($heartPosition);

        $arm = 2;

        $floorCenter = new Vector3($heartPosition->x, $heartPosition->y - 1, $heartPosition->z);

        $startX = $floorCenter->x - $arm;
        $endX = $floorCenter->x + $arm;
        $startZ = $floorCenter->z - $arm;
        $endZ = $floorCenter->z + $arm;

        self::createFloor($heartPosition->getWorld(), $startX, $endX, $startZ, $endZ, $heartPosition->y - 1);
        self::createFloor($heartPosition->getWorld(), $startX, $endX, $startZ, $endZ, $heartPosition->y + 3);

        $heartPosition->getWorld()->setBlock($heartPosition->add(0, -1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::SEA_LANTERN));
        
        $heartPosition->getWorld()->setBlock($heartPosition->add(0, 3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::SEA_LANTERN));

        $corner1 = new Vector3($heartPosition->x + $arm, $heartPosition->y, $heartPosition->z + $arm);
        $corner2 = new Vector3($heartPosition->x - $arm, $heartPosition->y, $heartPosition->z - $arm);
        $corner3 = new Vector3($heartPosition->x + $arm, $heartPosition->y, $heartPosition->z - $arm);
        $corner4 = new Vector3($heartPosition->x - $arm, $heartPosition->y, $heartPosition->z + $arm);

        foreach([$corner1, $corner2, $corner3, $corner4] as $corner) {
            for($y = $corner->y; $y <= $corner->y + 2; $y++)
                $heartPosition->getWorld()->setBlockIdAt($corner->x, $y, $corner->z, \pocketmine\item\ItemIds::OBSIDIAN);
        }
    }

    public static function createAirCube(Position $heartPosition) : void {
        $center = new Position($heartPosition->x, $heartPosition->y + 2, $heartPosition->z, $heartPosition->getWorld());

        $radiusXZ = 4;
        $radiusY = 3;

        $blockdata = [];

        for($x = $center->x - $radiusXZ; $x <= $center->x + $radiusXZ; $x++)
            for($y = $center->y - $radiusY; $y <= $center->y + $radiusY; $y++)
                for($z = $center->z - $radiusXZ; $z <= $center->z + $radiusXZ; $z++)
                    $blockdata[] = [$x, $y, $z];

        foreach($blockdata as $coord)
            $center->getWorld()->setBlockIdAt((int)$coord[0], (int)$coord[1], (int)$coord[2], \pocketmine\item\ItemIds::AIR);
    }

    public static function createFloor(Level $level, int $startX, int $endX, int $startZ, int $endZ, int $y) : void {
        $blockdata = [];

        for($x = $startX; $x <= $endX; $x++)
            for($z = $startZ; $z <= $endZ; $z++)
                $blockdata[] = [$x, $y, $z];

        foreach($blockdata as $coord)
            $level->setBlockIdAt((int)$coord[0], (int)$coord[1], (int)$coord[2], \pocketmine\item\ItemIds::OBSIDIAN);
    }
}