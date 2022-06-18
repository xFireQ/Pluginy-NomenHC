<?php

namespace Core\managers;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class SklepManager {
  
    public static function init() : void {
        
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS sklep (nick TEXT PRIMARY KEY COLLATE NOCASE, monety INT, wydane INT)");
    }
    
    public static function setDefault(Player $player) : void {
        $nick = $player->getName();
        
        
        Main::getDb()->query("INSERT INTO sklep (nick, monety, wydane) VALUES ('$nick', '0.00', '0.00')");
    }
    
    public static function setMoney(Player $player, float $money) : void {
        $nick = $player->getName();
        $countR = round ($money, 2);
        
        Main::getDb()->query("UPDATE sklep SET monety = '$countR' WHERE nick = '$nick'");
    }
    
    public static function setWydane(Player $player, float $money) : void {
        $nick = $player->getName();
        $countR = round ($money, 2);
        
        Main::getDb()->query("UPDATE sklep SET wydane = '$countR' WHERE nick = '$nick'");
    }
    
    public static function addMoney(string $nick, float $count) : void {
		$count = SklepManager::getMonety($nick) + $count;
		$countR = round ($count, 2);
		
		Main::getDb()->query("UPDATE sklep SET monety = '$countR' WHERE nick = '$nick'");
		
	}
	
	public static function removeMonety(string $nick, float $count) : void {
		$countR = round ($count, 2);

		Main::getDb()->query("UPDATE sklep SET monety = monety - '$countR' WHERE nick = '$nick'");
		SklepManager::addWydane($nick, $countR);
	}
	
	public static function addWydane(string $nick, float $count) : void {
		$count = SklepManager::getMonety($nick) + $count;
		$countR = round ($count, 2);
		
		Main::getDb()->query("UPDATE sklep SET wydane = '$countR' WHERE nick = '$nick'");
	}
    
    
    
    
    public static function getMonety(string $nick) {
        //$nick = $player->getName();
        
        
        $array = Main::getDb()->query("SELECT * FROM sklep WHERE nick = '" . $nick . "'")->fetchArray(SQLITE3_ASSOC);

        if(empty($array))
            return null;
            
        $value = $array['monety'];
        
        $valueR = round ($value, 2);
        
        
        return $valueR;
    }
    
}




