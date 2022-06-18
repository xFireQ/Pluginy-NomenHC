<?php

namespace Core\command\commands\admin;

use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;
use pocketmine\player\Player;
use Core\command\BaseCommand;

class FlyCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("fly", "Komenda fly", [], true, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {
	    
		 $nick = $sender->getName();
   if(empty($args)){
   	if(!isset($this->fly[$nick])){
   		$this->fly[$nick] = true;
   		$sender->setAllowFlight(true);
   		$sender->sendTitle("§9§lFly", "§7Latanie zostalo wlaczone");
   	}
   	else{
   		unset($this->fly[$nick]);
   		$sender->setAllowFlight(false);
   		$sender->sendTitle("§9§lFly", "§7Latanie zostalo wylaczone");
   	}
   	}
   }
}