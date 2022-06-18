<?php

namespace Core\task;

use pocketmine\scheduler\Task;

use pocketmine\level\Level;

use pocketmine\math\Vector3;

use pocketmine\block\Block;

class StoniarkaTask extends Task {
	
	private $level;
	private $pos;
	
	public function __construct(Level $level, Vector3 $pos) {
		$this->level = $level;
		$this->pos = $pos;
	}
	
	public function onRun(): void {
		if($this->level->getBlock($this->pos)->getId() == 0)
		 $this->level->setBlock($this->pos, BlockFactory::getInstance()->get(1));
	}
}