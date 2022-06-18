<?php

namespace Core\managers;

use Core\Main;

class Kit {

    public function setCooldown(string $nick, string $kit, int $time) : void {
    	   
        $date = date('d.m.Y H:i:s', strtotime(date("H:i:s")) + $time);
    	   
        Main::getInstance()->getDb()->query("INSERT INTO kits (nick, kit, date) VALUES ('$nick', '$kit', '$date')");
    }

    public function unsetCooldown(string $nick, string $kit) : void {
        Main::getInstance()->getDb()->query("DELETE FROM kits WHERE nick = '$nick' AND kit = '$kit'");
    }

    public function isCooldown(string $nick, string $kit) : bool {
        $result = Main::getInstance()->getDb()->query("SELECT * FROM kits WHERE nick = '$nick' AND kit = '$kit'");

        return !empty($result->fetchArray());
    }

 public function getCooldownFormat(string $nick, string $kit) : string {
 	
   $array = Main::getInstance()->getDb()->query("SELECT * FROM kits WHERE nick = '$nick' AND kit = '$kit'")->fetchArray(SQLITE3_ASSOC);
   
   $time = strtotime($array['date']) - time();

     $hours = floor($time / 3600);
     $minutes = floor(($time / 60) % 60);
     $seconds = $time % 60;

     if($hours < 10)
         $hours = "0{$hours}";

     if($minutes < 10)
         $minutes = "0{$minutes}";

     if($seconds < 10)
         $seconds = "0{$seconds}";

   return "§9§l{$hours}§r§8:§l§9{$minutes}§r§8:§9§l{$seconds}";
 }
}