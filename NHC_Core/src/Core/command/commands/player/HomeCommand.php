<?php

namespace Core\command\commands\player;

use Core\task\HomeTask;
use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use Core\Main;
use Core\managers\HomeManager;
use Core\command\BaseCommand;

class HomeCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("home", "Komenda home", [], true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

	    if(empty($args)) {
	        $homes = HomeManager::getHomes($sender);

	        if(empty($homes))
	            $sender->sendMessage(Main::format("Nie posiadasz zadnych domow!"));
	        else
	            $sender->sendMessage(Main::format("Twoje domy: §9".implode("§8, §9", $homes)));
	        return;
        }

	    if(!HomeManager::isHomeExists($sender, $args[0])) {
	        $sender->sendMessage(Main::format("Ten dom nie istnieje!"));
	        return;
        }

        $time = 10;

        $sender->sendMessage(Main::format("Teleportacja nastapi za §9$time §7sekund, nie ruszaj sie!"));

        $sender->addEffect(new EffectInstance(Effect::getEffect(9), 20*$time, 3));

        if(isset(Main::$homeTask[$sender->getName()]))
            Main::$homeTask[$sender->getName()]->cancel();

        Main::$homeTask[$sender->getName()] = Main::getInstance()->getScheduler()->scheduleDelayedTask(new HomeTask($sender, HomeManager::getHomePos($sender, $args[0]), $args[0]), 20*$time);
	}
}