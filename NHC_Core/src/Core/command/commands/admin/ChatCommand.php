<?php

namespace Core\command\commands\admin;


use pocketmine\command\{
	Command, CommandSender
};
use pocketmine\utils\TextFormat;

use pocketmine\utils\Config;

use Core\utils\Utils;

use pocketmine\player\Player;

use Core\command\BaseCommand;

use pocketmine\Server;

use Core\Main;

class ChatCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("chat", "komenda chat", [], false, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
     
     if(empty($args)) {
 	
 	     $sender->sendMessage(Main::format("Poprawne uzycie to §9/chat §8(§9on§8/§9off§8/§9clear§8)"));
     }
     foreach(Server::getInstance()->getOnlinePlayers() as $player) {
     if(isset($args[0])) {
         if($args[0] === "on") {
            Main::$chatOn = false;
            $player->sendMessage(Main::format("Chat zostal §9wlaczony §7przez administratora §9{$sender->getName()}"));
            
         }
         
         if($args[0] === "off") {
            Main::$chatOn = true;
            $player->sendMessage(Main::format("Chat zostal §9wylaczony §7przez administratora §9{$sender->getName()}"));
         }
         
         if($args[0] === "clear") {
                   for ($i = 0; $i < 100; $i++) {
                         $player->sendMessage(" ");
                   }
                   $player->sendMessage(Main::format("Chat zostal §9wyczyszczony §7przez administratora §9{$sender->getName()}§7!"));
         }
         }
          
     }
 }
 
  
}