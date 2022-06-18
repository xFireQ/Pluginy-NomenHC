<?php

namespace Core\command\commands\player;

use Core\command\BaseCommand;
use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;

class TpdenyCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("tpdeny", "komenda tpdeny", ["odrzuc"], true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}

	$nick = $sender->getName();

	if(empty($args)) {
	    if(empty(Main::$tp[$nick])) {
	        $sender->sendMessage("§r§8» §cNikt nie wyslal do ciebie prosby o teleportacje!");
	        return;
	    }

	    if(count(Main::$tp[$nick]) == 1) {
	        $player = $sender->getServer()->getPlayerExact(key(Main::$tp[$nick]));

	        unset(Main::$tp[$nick][$player->getName()]);
	        $player->sendMessage("§r§8» §7Gracz §9{$nick} §7odrzucil twoja prosbe o teleportacje");
	    } else {
	        $sender->sendMessage(Main::format("§r§8» §7Twoje prosby o teleportacje: §9"));

	        $requests = [];

	        foreach(Main::$tp[$nick] as $p => $time)
	            $requests[] = $p;

	        $sender->sendMessage(Main::format(implode("§7, §9", $requests)));
	    }
	    return;
	}

	if($args[0] == "*") {
	    foreach(Main::$tp[$nick] as $player => $time) {
	        $player = $sender->getServer()->getPlayerExact($player);

	        unset(Main::$tp[$nick][$player->getName()]);
	        $player->sendMessage("§r§8» §cGracz §4$nick §codrzucil twoja prosbe o teleportacje");
	    }
	} else {
	    $player = $sender->getServer()->getPlayerExact($args[0]);

	    if($player == null || !isset(Main::$tp[$nick][$player->getName()])) {
	        $sender->sendMessage("§r§8» §cTen gracz nie wyslal do ciebie porsby o teleportacje");
	        return;
	    }

	   unset(Main::$tp[$nick][$player->getName()]);
	        $player->sendMessage("§r§8» §7Gracz §9$nick §7odrzucil twoja prosbe o teleportacje");
	    }
	}
}