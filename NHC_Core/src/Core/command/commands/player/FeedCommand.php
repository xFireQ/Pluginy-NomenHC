<?php

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender, ConsoleCommandSender
};

use Core\Main;

use Core\command\BaseCommand;
use pocketmine\player\Player;

class FeedCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("feed", "Komenda feed", [], false, true);
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
            $sender->sendMessage(Main::format("Pomyslnie nakarmiono gracza §9{$player->getName()}§7!"));

        $player->setFood(20);
        //$player->sendMessage(Main::format("Zostales nakarmiony"));
        $player->sendTitle("§9§lFeed", "§7Zostales nakramiony Cheaty? :O");
	}
}