<?php

namespace Gildie\task;

use pocketmine\block\Block;
use pocketmine\scheduler\Task;

class SetHeartTask extends Task {

    private $block;

    public function __construct(Block $block) {
        $this->block = $block;
    }

    public function onRun(): void {
        $this->block->getWorld()->setBlock($this->block, $this->block);
    }
}