<?php

namespace Core\task;

use Core\user\User;
use Core\user\UserManager;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;

class TurbodropTask extends Task
{

    private int $time;
    private ?Player $player;

    public function __construct(Player $player, int $time)
    {
        $this->player = $player;
        $this->time = $time + 1;
    }

    public function onRun(): void
    {
        $this->time--;
        $player = $this->player;
        if ($player->isConnected()) {
            if ($this->time >= 1) {
                $time = $this->format($this->time);
                $player->sendTip("§r§6TurboDrop jest wlaczony §8[§f" . $time . "§8]");
            }

            if ($this->time <= 0) {
                $player->sendTitle("§r§r§6TurboDrop", "§7Turbodrop zostal §cwylaczony!");
                User::$tdTask[$player->getName()]->cancel();
                unset(User::$tdTask[$player->getName()]);
            }
        } else {
            UserManager::getUser($player->getName())->getDrop()->setTime($this->time);
            User::$tdTask[$player->getName()]->cancel();
        }

    }

    public function format($seconds)
    {
        $time = round($seconds);

        if ($time > 3600 * 24) {
            return sprintf('%02dd %02dm %02ds', ($time / 86400), ($time / 60 % 60), $time % 60);
        }

        if ($time > 3600) {
            return sprintf('%02dh %02dm %02ds', ($time / 3600), ($time / 60 % 60), $time % 60);
        }

        return sprintf('%02dm %02ds', ($time / 60 % 60), $time % 60);


    }
}