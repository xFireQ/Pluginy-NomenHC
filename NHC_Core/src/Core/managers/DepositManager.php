<?php

namespace Core\managers;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class DepositManager {

    public static function init() : void {

        Main::getInstance()->getDb()->query("CREATE TABLE IF NOT EXISTS deposit (nick TEXT, koxy INT, refy INT, perly INT, snow INT, rzucaki INT)");
    }

}