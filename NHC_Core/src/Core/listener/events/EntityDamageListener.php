<?php


namespace Core\listener\events;

use Core\fakeinventory\inventory\VillagerMenuInventory;
use pocketmine\entity\EntityIds;
use pocketmine\entity\Villager;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use Core\task\AntyLogoutTask;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use pocketmine\network\mcpe\protocol\PlaySoundPacket;
use pocketmine\entity\Entity;
use pocketmine\entity\projectile\{Arrow, Egg, Snowball};
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\entity\Attribute;
use pocketmine\entity\Living;
use Core\Main;
use Core\managers\PointsManager;
use Core\managers\ProtectManager;
use Core\util\GlobalVariables;
use stdClass;
use pocketmine\player\Player;
use pocketmine\Server;

class EntityDamageListener implements Listener {

    public function god(EntityDamageEvent $e)
    {
        $entity = $e->getEntity();

        if ($entity instanceof Player)
            if (isset(Main::$god[$entity->getName()]))
                $e->cancel(true);
    }

    public function pvp(EntityDamageByEntityEvent $event)
    {


        if($event instanceof EntityDamageByEntityEvent) {
            $event->setKnockback(0.320);
            $event->setAttackCooldown(7.6);
        }

        if($event->getEntity() instanceof Villager) {
            $event->cancel();
            if($event->getMetar() instanceof Player) {
                (new VillagerMenuInventory($event->getMetar()))->openFor([$event->getMetar()]);

            }
        }
    }


    public function terrainEntity(EntityDamageEvent $e) {
        $entity = $e->getEntity();

        if($e instanceof EntityDamageByEntityEvent)
            return;

        if(!ProtectManager::canDamage($entity))
            $e->cancel(true);
    }

    public function terrainEntityByEntity(EntityDamageEvent $e) {
        $entity = $e->getEntity();

        if($e instanceof EntityDamageByEntityEvent) {
            $damager = $e->getMetar();
            if(!ProtectManager::canDamageEntity($entity, $damager))
                $e->cancel(true);
        }
    }



}