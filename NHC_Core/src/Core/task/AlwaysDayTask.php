<?php

namespace Core\task;

use pocketmine\Server;
use pocketmine\scheduler\Task;

class AlwaysDayTask extends Task {

	public function onRun() : void {
		foreach(Server::getInstance()->getWorldManager()->getWorlds() as $level) {
			if($level->getDisplayName() == "world")
                $level->setTime(0);
            else
                $level->setTime(0);
		}
	}
}