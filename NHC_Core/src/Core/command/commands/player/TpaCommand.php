<?php

namespace Core\command\commands\player;

use Core\command\BaseCommand;
use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use Core\Main;

class TpaCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("tpa", "komenda tpa", ["teleportuj"], true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}

		if(empty($args)) {
		    $sender->sendMessage("Poprane uzycie to: §9/tpa §8[§9nick§8]");
		    return;
		}

		$player = $sender->getServer()->getPlayerExact($args[0]);

		if($player == null) {
		    $sender->sendMessage("§r§8» §7Ten gracz jest offline§7!");
		    return;
		}

		if($player->getName() == $sender->getName()) {
		    $sender->sendMessage("§r§8» §7Nie mozesz wyslac teleportacji do siebie!");
		   return;
        }

		$nick = $sender->getName();
		$tp_nick = $player->getName();

		if(isset(Main::$tp[$tp_nick][$nick])) {
		    $sender->sendMessage("§r§8» §7Wyslano juz prosbe o teleportacje do tego gracza!");
		    return;
		}

        Main::$tp[$tp_nick][$nick] = time();

        $sender->sendMessage("§r§8» §7Wyslano prosbe o teleportacje do gracza §9".$tp_nick."§7!");

        $player->sendMessage("§r§8» §7Gracz §9$nick §7wyslal do ciebie prosbe o teleportacje!\n§r§8» §7Uzyj §9/tpaccept§7, aby zaakceptowac");
    }
}