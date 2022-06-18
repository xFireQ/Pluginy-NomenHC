<?php

namespace Core\drop;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class DropManager {
  
    public static function init() : void {

        Main::getInstance()->getDb()->query("CREATE TABLE IF NOT EXISTS 'drop' (nick TEXT, diamenty TEXT, emeraldy TEXT, zloto TEXT, zelazo TEXT, perly TEXT, tnt TEXT, nicie TEXT, szlam TEXT, obsydian TEXT, biblioteczki TEXT, jablka TEXT, wegiel TEXT, cobblestone TEXT, time INT)");
    }
    
}




