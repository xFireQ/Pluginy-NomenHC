<?php

namespace Gildie\utils;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemIds;
use pocketmine\level\Level;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\world\World;

class ShapesUtils {

    public static function createGuildShape(Position $heartPosition) : void {
        self::createAirCube($heartPosition);
        $arm = 3;

        $floorCenter = new Vector3($heartPosition->x, $heartPosition->y - 1, $heartPosition->z);

        $startX = $floorCenter->x - $arm;
        $endX = $floorCenter->x + $arm;
        $startZ = $floorCenter->z - $arm;
        $endZ = $floorCenter->z + $arm;

        self::createFloor($heartPosition->getWorld(), $startX, $endX, $startZ, $endZ, $heartPosition->y - 1);
        self::createFloor($heartPosition->getWorld(), $startX, $endX, $startZ, $endZ, $heartPosition->y + 3);

        $heartPosition->getWorld()->setBlock($heartPosition->add(0, -1, 0), BlockFactory::getInstance()->get(ItemIds::SEA_LANTERN, 0));
        
        $heartPosition->getWorld()->setBlock($heartPosition->add(0, 3, 0), BlockFactory::getInstance()->get(ItemIds::SEA_LANTERN, 0));

        $corner1 = new Vector3($heartPosition->x + $arm, $heartPosition->y, $heartPosition->z + $arm);
        $corner2 = new Vector3($heartPosition->x - $arm, $heartPosition->y, $heartPosition->z - $arm);
        $corner3 = new Vector3($heartPosition->x + $arm, $heartPosition->y, $heartPosition->z - $arm);
        $corner4 = new Vector3($heartPosition->x - $arm, $heartPosition->y, $heartPosition->z + $arm);

        foreach([$corner1, $corner2, $corner3, $corner4] as $corner) {
            for($y = $corner->y; $y <= $corner->y + 2; $y++)
                $heartPosition->getWorld()->setBlockAt($corner->x, $y, $corner->z, VanillaBlocks::OBSIDIAN());
        }

        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY(), $heartPosition->getZ()), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY(), $heartPosition->getZ()), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX(), $heartPosition->getY(), $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX(), $heartPosition->getY(), $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY(), $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY(), $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY(), $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY(), $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY(), $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY(), $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY(), $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY(), $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY(), $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY(), $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY(), $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY(), $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));

        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+2, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+2, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+2, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+2, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));

        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+2, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+2, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+2, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+2, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0));


        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+2, $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 6));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 6));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY(), $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 2));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+2, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_SLAB, 13));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY()+2, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 4));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 4));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY(), $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 8));//8

        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+2, $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 7));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 7));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY(), $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 3));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY()+2, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 5));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 5));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY(), $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 1));//8
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+2, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_SLAB, 13));

        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+2, $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 6));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 6));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY(), $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 2));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+2, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_SLAB, 13));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY()+2, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 5));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 5));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY(), $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 1));//8

        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+2, $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 7));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 7));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY(), $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 3));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+2, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_SLAB, 13));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY()+2, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 4));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 4));
        $heartPosition->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY(), $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS, 8));//8
    }

    public static function createAirCube(Position $heartPosition) : void {
        $center = new Position($heartPosition->x, $heartPosition->y + 2, $heartPosition->z, $heartPosition->getWorld());

        $radiusXZ = 3;
        $radiusY = 4;
        $blockdata = [];

        for($x = $center->x - $radiusXZ; $x <= $center->x + $radiusXZ; $x++)
            for($y = $center->y - $radiusY; $y <= $center->y + $radiusY; $y++)
                for($z = $center->z - $radiusXZ; $z <= $center->z + $radiusXZ; $z++)
                    $blockdata[] = [$x, $y, $z];

        foreach($blockdata as $coord)
            $center->getWorld()->setBlockAt((int)$coord[0], (int)$coord[1], (int)$coord[2], VanillaBlocks::AIR());
    }

    public static function createFloor(World $level, int $startX, int $endX, int $startZ, int $endZ, int $y) : void {
        $blockdata = [];

        for($x = $startX; $x <= $endX; $x++)
            for($z = $startZ; $z <= $endZ; $z++)
                $blockdata[] = [$x, $y, $z];

        foreach($blockdata as $coord)
            $level->setBlockAt((int)$coord[0], (int)$coord[1], (int)$coord[2], VanillaBlocks::OBSIDIAN());
    }
}