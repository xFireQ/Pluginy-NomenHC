<?php

namespace Core\managers;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class OsManager {

    public static function init() : void {

        Main::getInstance()->getDb()->query("CREATE TABLE IF NOT EXISTS os (nick TEXT, stone INT, stoneClaim TEXT)");
    }

    public static function getBreakStone(String $name): bool {
        $array = Main::getInstance()->getDb()->query("SELECT * FROM os WHERE nick = '$name'")->fetchArray();
        return $array["stone"];
    }

    public static function setBreakStone(String $name): bool {
        $array = Main::getInstance()->getDb()->query("UPDATE os SET stone = stone + '1' WHERE nick = '$name'")->fetchArray();
    }

}