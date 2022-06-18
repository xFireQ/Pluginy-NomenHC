<?php

namespace Core\command\commands\player;

use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};
use pocketmine\level\sound\ClickSound;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\AddActorPacket;
use Core\Main;

use Core\command\BaseCommand;

class MsgCommand extends BaseCommand {
	
	public function __construct() {
		parent::__construct("msg", "Komenda msg");
	}
	
	public function onCommand(CommandSender $sender, array $args) : void {

		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}
		
		if(!isset($args[1])) {
			$sender->sendMessage(Main::format("Uzycie: /msg §8[§9nick§8] [§9wiadomosc§8]"));
			return;
		}
		
		$player = $sender->getServer()->getPlayerExact(array_shift($args));
		$msg = trim(implode(" ", $args));
		
		if(!$player) {
			$sender->sendMessage("§cTen gracz jest offline§7!");
			return;
		}
		
		$sender->sendMessage("§9Ja §8§l»§r §9{$player->getName()}§8: §7$msg");
		$player->sendMessage("§9{$sender->getName()} §8§l»§r §9Ja§8: §7$msg");
        $player->getWorld()->addSound(new ClickSound($player), [$player]);
		
		Main::$msgR[$sender->getName()] = $player->getName();
		Main::$msgR[$player->getName()] = $sender->getName();
	}
}