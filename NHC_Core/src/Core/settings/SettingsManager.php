<?php

namespace Core\settings;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class SettingsManager {
  
    public static function init() : void {
        
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS settings (nick TEXT, value TEXT)");
    }
    
    public static function setDefault(Player $player) : void {
        $nick = $player->getName();
        
        
        Main::getDb()->query("INSERT INTO settings (nick, value) VALUES ('$nick', 'true')");
    }
    
    public static function setFalse(Player $player) : void {
        $nick = $player->getName();
        
        
        Main::getDb()->query("UPDATE settings SET value = 'false' WHERE nick = '$nick'");
    }
    
    public static function setTrue(Player $player) : void {
        $nick = $player->getName();
        
        
        Main::getDb()->query("UPDATE settings SET value = 'true' WHERE nick = '$nick'");
    }
    
    
    public static function getValue(Player $player)  {
        $nick = $player->getName();
        
        
        $array = Main::getDb()->query("SELECT * FROM settings WHERE nick = '" . $nick . "'")->fetchArray(SQLITE3_ASSOC);

        if(empty($array))
            return null;
            
        $value = $array["value"];
        
        
        return $value;
    }
    
}




