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

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Transparent;
use pocketmine\entity\Entity;
use pocketmine\event\block\BlockGrowEvent;
use pocketmine\event\entity\EntityDamageByBlockEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;
use pocketmine\math\AxisAlignedBB;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\Server;

class Cactus extends Transparent {

    protected $id = self::CACTUS;

    public function __construct(int $meta = 0){
        $this->meta = $meta;
    }

    public function getHardness() : float{
        return 0.4;
    }

    public function hasEntityCollision() : bool{
        return true;
    }

    public function getName() : string{
        return "Cactus";
    }

    protected function recalculateBoundingBox() : ?AxisAlignedBB{

        return new AxisAlignedBB(
            $this->x + 0.0625,
            $this->y + 0.0625,
            $this->z + 0.0625,
            $this->x + 0.9375,
            $this->y + 0.9375,
            $this->z + 0.9375
        );
    }

    public function onEntityCollide(Entity $entity) : void{
        //$ev = new EntityDamageByBlockEvent($this, $entity, EntityDamageEvent::CAUSE_CONTACT, 0);
       // $entity->attack($ev);
    }

    public function onNearbyBlockChange() : void{
        $down = $this->getSide(Vector3::SIDE_DOWN);
        if($down->getId() !== self::SAND and $down->getId() !== self::CACTUS){
            $this->getWorld()->useBreakOn($this);
        }else{
            for($side = 2; $side <= 5; ++$side){
                $b = $this->getSide($side);
                if(!$b->canBeFlowedInto()){
                    $this->getWorld()->useBreakOn($this);
                    break;
                }
            }
        }
    }

    public function ticksRandomly() : bool{
        return true;
    }

    public function onRandomTick() : void{
        if($this->getSide(Vector3::SIDE_DOWN)->getId() !== self::CACTUS){
            if($this->meta === 0x0f){
                for($y = 1; $y < 3; ++$y){
                    $b = $this->getWorld()->getBlockAt($this->x, $this->y + $y, $this->z);
                    if($b->getId() === self::AIR){
                        Server::getInstance()->getPluginManager()->callEvent($ev = new BlockGrowEvent($b, BlockFactory::get(\pocketmine\item\ItemIds::CACTUS)));
                        if(!$ev->isCancelled()){
                            $this->getWorld()->setBlock($b, $ev->getNewState(), true);
                        }
                    }
                }
                $this->meta = 0;
                $this->getWorld()->setBlock($this, $this);
            }else{
                ++$this->meta;
                $this->getWorld()->setBlock($this, $this);
            }
        }
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $down = $this->getSide(Vector3::SIDE_DOWN);
        if($down->getId() === self::SAND or $down->getId() === self::CACTUS){
            $block0 = $this->getSide(Vector3::SIDE_NORTH);
            $block1 = $this->getSide(Vector3::SIDE_SOUTH);
            $block2 = $this->getSide(Vector3::SIDE_WEST);
            $block3 = $this->getSide(Vector3::SIDE_EAST);
            if($block0->isTransparent() and $block1->isTransparent() and $block2->isTransparent() and $block3->isTransparent()){
                $this->getWorld()->setBlock($this, $this, true);

                return true;
            }
        }

        return false;
    }

    public function getVariantBitmask() : int{
        return 0;
    }
}
