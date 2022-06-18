<?php

declare(strict_types=1);

namespace Core\events\group;

use pocketmine\event\Event;
use Core\group\Group;

abstract class GroupEvent extends Event {
	
	protected $group;

	public function getGroup() : Group {
		return $this->group;
	}
}