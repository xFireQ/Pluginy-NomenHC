<?php

namespace Core\task;

use Core\user\User;
use Core\user\UserManager;
use pocketmine\scheduler\Task;
use pocketmine\player\Player;

class VanishTask extends Task {

    private int $time;
    private int $dtime;
    private ?Player $player;

    public function __construct(int $time, Player $player) {
        $this->time = $time + 1;
        $this->dtime = $time + 1;
        $this->player = $player;
    }

    public function onRun(): void {
        $this->time--;
        $player = $this->player;
        $name = $player->getName();

        $userV = UserManager::getUser($name);
        if(!$player->isConnected()) {
            User::$vanishTask[$name]->cancel();
            return;
        }

        if($userV->getVanish() === "WLACZONY") {
            $player->sendTip("§r§f§k|||§r §l§aVANISH §r§k§f|||");
        }

        $this->time = $this->dtime;
    }
}