<?php

declare(strict_types=1);

namespace Core\events\group;

use Core\group\Group;

class GroupUpdateDataEvent extends GroupEvent {
	
	public function __construct(Group $group) {
		$this->group = $group;
	}
}