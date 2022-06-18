<?php

namespace Core\managers;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class PointsManager {
  
    public static function init() : void {
        
        Main::getInstance()->getDb()->query("CREATE TABLE IF NOT EXISTS points (nick TEXT, points INT)");
    }
    
}




