<?php

namespace Core\command\commands\player;

use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;

use Core\command\BaseCommand;

class ListCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("list", "Komenda list", [], false);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

   $sender->sendMessage(Main::format("Aktualnie gra: §9".count(Server::getInstance()->getOnlinePlayers()) . "§7 graczy"));
	}
}