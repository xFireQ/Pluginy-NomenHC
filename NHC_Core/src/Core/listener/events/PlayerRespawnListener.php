<?php

declare(strict_types=1);

namespace Core\listener\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerRespawnEvent;
use Core\Main;

class PlayerRespawnListener implements Listener {
	
	public function TpOnRespawn(PlayerRespawnEvent $e)
    {
        $e->setRespawnPosition($e->getPlayer()->getWorld()->getSafeSpawn());
    }
    
}