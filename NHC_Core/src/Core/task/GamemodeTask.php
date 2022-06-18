<?php

namespace Core\task;

use pocketmine\network\mcpe\protocol\types\GameMode;
use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class GamemodeTask extends Task {

    private int $time;
    private Player $player;

    public function __construct(int $time, Player $player) {
        $this->time = $time;
        $this->player = $player;
    }

    public function onRun(): void {
        $this->time--;

        if($this->time == 0) {
            if($this->player->isOnline())
                $this->player->setGamemode(0);
        }
    }
}