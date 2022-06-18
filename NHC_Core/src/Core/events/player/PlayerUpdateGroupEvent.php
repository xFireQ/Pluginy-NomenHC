<?php

declare(strict_types=1);

namespace Core\events\player;

use pocketmine\player\Player;
use pocketmine\event\player\PlayerEvent;

class PlayerUpdateGroupEvent extends PlayerEvent {
	
	public function __construct(Player $player) {
		$this->player = $player;
	}
}