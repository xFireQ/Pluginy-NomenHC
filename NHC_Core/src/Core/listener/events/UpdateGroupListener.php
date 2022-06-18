<?php

declare(strict_types=1);

namespace Core\listener\events;

use pocketmine\event\Listener;
use Core\events\player\PlayerUpdateGroupEvent;
use Core\Main;
use Core\managers\NameTagManager;

class UpdateGroupListener implements Listener {
	
	public function updateNametag(PlayerUpdateGroupEvent $e) {
		NameTagManager::updateNameTag($e->getPlayer());
	}
}