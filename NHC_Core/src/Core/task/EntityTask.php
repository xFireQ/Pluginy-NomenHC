<?php

namespace Core\task;

use pocketmine\entity\Entity;
use pocketmine\scheduler\Task;

class EntityTask extends Task {
    public function __construct(
        private int $time,
        private Entity $entity
    ) {}

    public function onRun(): void {
        $this->time--;

        if($this->entity === null) {
            $this->getHandler()->cancel();
            return;
        }
        $this->entity->setRotation($this->entity->getYaw()+2.3, 0);
      //  $this->entity->move(0.5, 0, 0);
      //  $this->entity->setGenericFlag(Entity::DATA_FLAG_CAN_POWER_JUMP, true);


        if($this->time === 0) $this->time = 10;
    }
}