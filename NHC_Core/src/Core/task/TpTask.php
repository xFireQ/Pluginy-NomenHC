<?php

namespace Core\task;

use pocketmine\scheduler\Task;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\world\Position;
use Core\Main;

class TpTask extends Task {

    private $player;

    public function __construct(Player $player, Position $pos) {
        $this->player = $player;
        $this->pos = $pos;
    }

    public function onRun(): void {

        $player = $this->player;

        unset(Main::$tpTask[$player->getName()]);

        if(Server::getInstance()->getPlayerExact($player->getName())) {

            //$player->teleport($this->pos);

            $player->sendMessage("§r§8» §7Teleportacja zostala zakonczona pomyslnie");
        }
    }
}