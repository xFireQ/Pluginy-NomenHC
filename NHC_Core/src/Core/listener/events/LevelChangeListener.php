<?php

declare(strict_types=1);

namespace Core\listener\events;

use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityLevelChangeEvent;
use Core\Main;
use Core\managers\NameTagManager;

class LevelChangeListener implements Listener {
	
	/*public function updatePermissions(EntityLevelChangeEvent $e) {
		$entity = $e->getEntity();
		
		if($entity instanceof Player) {
			$entity->setLevel($e->getTarget());
		 Main::getInstance()->getGroupManager()->getPlayer($entity->getName())->updatePermissions();
		}
	}*/
	
	public function updateNametag(EntityLevelChangeEvent $e) {
		$entity = $e->getEntity();
		
		if($entity instanceof Player)
		 NameTagManager::updateNameTag($entity);
	}
}