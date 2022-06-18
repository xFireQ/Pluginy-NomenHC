<?php

declare(strict_types=1);

namespace Core\entity\projectile;

use pocketmine\player\Player;
use pocketmine\item\Item;
use pocketmine\entity\projectile\EnderPearl as PMEnderPearl;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\ProjectileHitEvent;
use pocketmine\event\entity\ProjectileHitBlockEvent;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use Core\Main;

class EnderPearl extends PMEnderPearl {


     public $coords = array(
        "pos1" => array(
            "x" => -37,
            "z" => 36
        ),

        "pos2" => array(
            "x" => 36,
            "z" => -37
        ),
    );

    protected function onHit(ProjectileHitEvent $event) : void{
        $owner = $this->getOwningEntity();

        if($owner !== null){
            $vector = $event->getRayTraceResult()->getHitVector();
            $x = $vector->getPosition()->getPosition()->getFloorX();
            $z = $vector->getPosition()->getFloorZ();

            $border = floor(1800 / 2);

            if($x >= $border || $x <= -$border || $z >= $border || $z <= -$border) {
                if($owner instanceof Player)
                    $owner->sendMessage(Main::format("Nie mozesz rzucic perly za border!"));

                $owner->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL));
                return;
            }

            $vector = $event->getRayTraceResult()->getHitVector();
            $x = $vector->getPosition()->getPosition()->getFloorX();
            $z = $vector->getPosition()->getFloorZ();

            if($z <  36 and $z > -37) {
                if ($x < 36 and $x > -37) {
                    if ($owner instanceof Player)
                        $owner->sendMessage(Main::format("Nie mozesz rzucic perly na spawn"));

                    $owner->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL));
                    return;
                }
            }

            $this->level->broadcastLevelEvent($owner, LevelEventPacket::EVENT_PARTICLE_ENDERMAN_TELEPORT);
            $this->level->addSound(new EndermanTeleportSound($owner));
            $owner->teleport($vector);
            $this->level->addSound(new EndermanTeleportSound($owner));

            $owner->attack(new EntityDamageEvent($owner, EntityDamageEvent::CAUSE_FALL, 0.5));
        }
    }

}