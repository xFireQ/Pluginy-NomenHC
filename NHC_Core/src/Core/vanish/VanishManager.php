<?php

namespace Core\vanish;

use Core\Main;
use pocketmine\player\Player;

class VanishManager {

    private array $vanish = [];

    public static function init() : void {
        Main::getInstance()->getDb()->query("CREATE TABLE IF NOT EXISTS vanish (player TEXT, status TEXT)");
    }

    public static function load(): void {
        $vanish = new Vanish();
        $db = Main::getInstance()->getDb()->query("SELECT * FROM vanish WHERE player = '{$player}'");
    }

    public static function createUser(Player $player) {

    }
}