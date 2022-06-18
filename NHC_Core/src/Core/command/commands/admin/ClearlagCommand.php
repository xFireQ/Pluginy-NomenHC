<?php

namespace Core\command\commands\admin;

use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;

use Core\command\BaseCommand;

//use pocketmine\Server;

class ClearlagCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("clearlag", "Komenda clearlag", [], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {
		
		Main::getInstance()->clearlag();
        
	}
} 
