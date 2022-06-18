<?php

namespace Core\task;

use Core\format\Format;
use pocketmine\Server;
use Core\Main;
use Core\user\User;
use Core\user\UserManager;
use pocketmine\scheduler\Task;
use pocketmine\player\Player;
use pocketmine\player\GameMode;

class WhiteListTask extends Task {

    private int $lastMessage;

    public function __construct() {
        $this->lastMessage = 30;
    }

    public function onRun(): void {

    }

    public static function dateFormat() : string {
        $date = Main::$whitelist->get("date");

        if($date == null)
            return "§7START JUZ NIEDLUGO!";

        $time = strtotime($date) - time();

        $days = intval(intval($time) / (3600*24));
        $hours = (intval($time) / 3600) % 24;
        $minutes = (intval($time) / 60) % 60;
        $seconds = intval($time) % 60;

        if($days < 10)
            $days = "0".$days;

        if($hours < 10)
            $hours = "0".$hours;

        if($minutes < 10)
            $minutes = "0".$minutes;

        if($seconds < 10)
            $seconds = "0".$seconds;

        return "§7Startujemy za: §9{$days} §7dni, §9{$hours} §7godzin, §9{$minutes} §7minut §9{$seconds} §7i sekund";
    }
}