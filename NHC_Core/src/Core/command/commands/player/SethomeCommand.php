<?php

namespace Core\command\commands\player;

use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};
use Core\Main;
use Core\managers\HomeManager;
use Core\command\BaseCommand;

class SethomeCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("sethome", "Komenda sethome", [], true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

	    if(empty($args)) {
	        $sender->sendMessage(Main::format("Poprawne uzycie: /sethome §8(§9nazwa domu§8)"));
	        return;
        }

        if(!ctype_alnum($args[0])) {
            $sender->sendMessage("§cDom moze zawierac tylko litery i cyfry");
            return;
        }

	    if(HomeManager::getHomesCount($sender) >= HomeManager::getMaxHomesCount($sender)) {
	        $sender->sendMessage(Main::format("Nie mozesz stworzyc wiecej domow! §8(§9".HomeManager::getMaxHomesCount($sender)."§8)"));
	        return;
        }

	    if(HomeManager::isHomeExists($sender, $args[0])) {
	        $sender->sendMessage(Main::format("Ten dom juz istnieje!"));
	        return;
        }

	    HomeManager::setHome($sender, $args[0], $sender->asVector3());

	    $sender->sendMessage(Main::format("Utworzono dom o nazwie §9$args[0]"));
	}
}