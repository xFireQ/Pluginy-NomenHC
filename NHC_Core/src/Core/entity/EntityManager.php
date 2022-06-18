<?php

namespace Core\entity;

use Core\entity\projectile\EnderPearl;
use pocketmine\entity\Entity;

class EntityManager {
	
	public static function init() : void {
        //Entity::registerEntity(EnderPearl::class, false, ['ThrownEnderpearl', 'minecraft:ender_pearl']);
    }
}