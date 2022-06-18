<?php

namespace Core\command\commands\player;

use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};
use pocketmine\level\sound\ClickSound;
use Core\Main;
use Core\command\BaseCommand;

class RCommand extends BaseCommand {
	
	public function __construct() {
		parent::__construct("r", "Komenda r");
	}
	
	public function onCommand(CommandSender $sender, array $args) : void {

		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}
		
		if(empty($args)) {
			$sender->sendMessage(Main::format("Poprawne uzycie: /r §8[§9wiadomosc§8]"));
			return;
		}
		
		$msg = implode(" ", $args);
		
		if(!isset(Main::$msgR[$sender->getName()]) || !($player = $sender->getServer()->getPlayerExact(Main::$msgR[$sender->getName()]))) {
			$sender->sendMessage("§9Ja §8§l»§r §9{$sender->getName()}§8: §7$msg");
		$sender->sendMessage("§9{$sender->getName()} §8§l»§r §9Ja§8: §7$msg");
			return;
		}
		
		$sender->sendMessage("§9Ja §8§l»§r §9{$player->getName()}§8: §7$msg");
		$player->sendMessage("§9{$sender->getName()} §8§l»§r §9Ja§8: §7$msg");
        $player->getWorld()->addSound(new ClickSound($player), [$player]);
	}
}