<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
	Command, CommandSender,
	ConsoleCommandSender
};

use Core\Main;

use Core\command\BaseCommand;

class GodCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("god", "Komenda god", [], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

		$player = $sender;

		if(isset($args[0])) {
            $player = $sender->getServer()->getPlayerExact($args[0]);

            if($player == null) {
        	    $sender->sendMessage(Main::format("Tego gracza aktualnie nie ma na serwerze!"));
                return;
        	}
        }

        if($player instanceof \pocketmine\console\ConsoleCommandSender) {
            $player->sendMessage("§Tej komendy mozesz uzyc tylko w grze!");
            return;
        }

        if(!isset(Main::$god[$player->getName()])) {
            Main::$god[$player->getName()] = true;

            if(!$player === $sender || $sender instanceof \pocketmine\console\ConsoleCommandSender)
                $sender->sendMessage("§7Wlaczono niesmiertelnosc graczu §9{$player->getName()}§7!");

            $player->sendMessage("§7Niesmiertelnosc zostala §awlaczona§7!");
            $sender->sendTitle("§9§lGod", "§7God zostal wlaczony");
        } else {
             unset(Main::$god[$player->getName()]);

             if(!$player === $sender || $sender instanceof \pocketmine\console\ConsoleCommandSender)
                 $sender->sendMessage("§7Wylaczono niesmiertelnosc graczu §9{$player->getName()}§7!");

             $player->sendMessage("§7Niesmiertelnosc zostala §9wylaczona§7!");
             $sender->sendTitle("§9§lGod", "§7God zostal wylaczony");
        }
    }
}