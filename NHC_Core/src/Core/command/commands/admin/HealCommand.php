<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
	Command, CommandSender, ConsoleCommandSender
};

use Core\Main;

use pocketmine\player\Player;

use Core\command\BaseCommand;

class HealCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("heal", "Komenda heal", [], false, true);
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
            $player->sendMessage("§cTej komendy mozesz uzyc tylko w grze!");
            return;
        }

        if($player !== $sender || $sender  instanceof \pocketmine\console\ConsoleCommandSender)
            $sender->sendMessage(Main::format("Pomyslnie uleczono gracza §9{$player->getName()}§7!"));

        $player->setHealth($player->getMaxHealth());
        //$player->sendMessage("Zostales uleczony!");
        $player->sendTitle("§9§lHeal", "§7Zostales uleczony");
	}
}