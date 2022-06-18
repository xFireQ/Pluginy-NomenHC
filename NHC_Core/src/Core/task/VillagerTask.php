<?php

namespace Core\task;

use pocketmine\entity\Entity;
use pocketmine\scheduler\Task;

class VillagerTask extends Task {

    private int $time;
    private int $startTime;
    private ?Entity $entity;

    public function __construct(int $time, Entity $entity) {
        $this->time = $time + 1;
        $this->startTime = $time + 1;
        $this->entity = $entity;
    }

    public function onRun(): void
    {
        $this->time--;

        if($this->time === 6)
            $this->entity->setNameTag("§r§l§9VILLAGER");
        else if ($this->time === 3)
            $this->entity->setNameTag("§r§l§fVILLAGER");



        if($this->time === 0) $this->time = $this->startTime;
    }
}