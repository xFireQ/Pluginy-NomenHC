<?php

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender, ConsoleCommandSender
};

use Core\Main;

use Core\command\BaseCommand;
use pocketmine\player\Player;

use Core\fakeinventory\inventory\EffectInventory;

class EffectCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("efekty", "Komenda efekty", [], false, false);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

        (new EffectInventory($sender))->openFor([$sender]);
	}
}