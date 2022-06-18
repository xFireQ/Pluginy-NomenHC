<?php

namespace Core\Block;

use pocketmine\block\Block;
use pocketmine\block\BlockFactory;
use pocketmine\block\Liquid;
use pocketmine\block\StillWater;
use pocketmine\entity\Entity;
use pocketmine\entity\WaterAnimal;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\player\Player;

class Water extends \pocketmine\block\Water {
    protected $id = self::WATER;

    public function __construct(int $meta = 0){
        $this->meta = $meta;
    }

    public function getName() : string{
        return "Water";
    }

    public function getLightFilter() : int{
        return 2;
    }

    public function getStillForm() : Block {
        return BlockFactory::get(\pocketmine\item\ItemIds::WATER, $this->meta);
    }

    public function getFlowingForm() : Block{
        return BlockFactory::get(\pocketmine\item\ItemIds::FLOWING_WATER, $this->meta);
    }

    public function getBucketFillSound() : int{
        return LevelSoundEventPacket::SOUND_BUCKET_FILL_WATER;
    }

    public function getBucketEmptySound() : int{
        return LevelSoundEventPacket::SOUND_BUCKET_EMPTY_WATER;
    }

    public function tickRate() : int{
        return 10000;
    }

    public function onEntityCollide(Entity $entity) : void{
        $entity->resetFallDistance();
        if($entity->getFireTicks() > 0){
            $entity->extinguish();
        }

        $entity->resetFallDistance();
    }

    public function place(Item $item, Block $blockReplace, Block $blockClicked, int $face, Vector3 $clickVector, Player $player = null) : bool{
        $ret = $this->getWorld()->setBlock($this, $this, true, false);
        $this->getWorld()->scheduleDelayedBlockUpdate($this, $this->tickRate());

        return $ret;
    }
}