<?php

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;

use Core\command\BaseCommand;

class PrzyznajesieCommand extends BaseCommand {
	
	public function __construct() {
		parent::__construct("przyznajesie", "Komenda przyznajesie");
	}
	
	public function onCommand(CommandSender $sender, array $args) : void {

		$nick = $sender->getName();
		
		if(!isset(Main::$spr[$nick])) {
			$sender->sendMessage(Main::format("Musisz byc sprawdzany aby uzyc tej komendy!"));
			return;
		}
		
		//$api = Main::getInstance()->getBanAPI();
		
		//$api->setTempBan($nick, "Przyznanie sie do cheatow", Main::$spr[$nick][1], (24 * 3600) * 3);
		
		//$sender->teleport($sender->getWorld()->getSafeSpawn());
		
		unset(Main::$spr[$nick]);
		
		//$sender->kick($api->getBanMessage($sender), false);
		
		$sender->getServer()->broadcastMessage(Main::format("Gracz §b$nick §7przyznal sie do cheatow"));
	}
}