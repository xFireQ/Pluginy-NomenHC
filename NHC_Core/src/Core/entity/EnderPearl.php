<?php

namespace Core\entity;

use pocketmine\block\Block;
use pocketmine\entity\projectile\EnderPearl as PMEnderPearl;
use pocketmine\math\RayTraceResult;
use pocketmine\player\Player;
use Core\Main;

class EnderPearl extends PMEnderPearl{
    public function onHitBlock(Block $blockHit, RayTraceResult $hitResult) : void {

        $entity = $this->getOwningEntity();



        if($entity instanceof Player)
            Main::$noclipWhitelist[$entity->getName()] = time() + 5;

        parent::onHitBlock($blockHit, $hitResult); // TODO: Change the autogenerated stub
    }

}