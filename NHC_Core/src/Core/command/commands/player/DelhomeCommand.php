<?php

namespace Core\command\commands\player;

use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};
use Core\Main;
use Core\managers\HomeManager;
use Core\command\BaseCommand;

class DelhomeCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("delhome", "Komenda delhome", [], true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

	    if(empty($args)) {
	        $sender->sendMessage(Main::format("Poprawne uzycie: /delhome §8(§9nazwa domu§8)"));
	        return;
        }
        
        if(isset($args[0])) {
            if(!ctype_alnum($args[0])) {
                $sender->sendMessage("§cDom moze zawierac tylko litery i cyfry");
                return;
            }
	    if(!HomeManager::isHomeExists($sender, $args[0])) {
	        $sender->sendMessage(Main::format("Ten dom nie istnieje!"));
	        return;
        }

	    HomeManager::deleteHome($sender, $args[0]);

	    $sender->sendMessage(Main::format("Pomyslnie usunieto dom §9$args[0]"));
        } else {
            $sender->sendMessage(Main::format("Ten dom nie istnieje!"));
        }
	}
}