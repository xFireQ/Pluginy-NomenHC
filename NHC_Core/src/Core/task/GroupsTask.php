<?php

declare(strict_types=1);

namespace Core\task;

use pocketmine\scheduler\Task;
use Core\Main;

class GroupsTask extends Task {
	
	public function onRun(): void {
		Main::getInstance()->getProvider()->taskProccess();
	}
}