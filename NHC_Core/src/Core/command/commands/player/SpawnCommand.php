<?php

namespace Core\command\commands\player;

use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

use Core\Main;

use Core\task\SpawnTask;

use Core\command\BaseCommand;

class SpawnCommand extends BaseCommand {
	
	public function __construct() {
		parent::__construct("spawn", "Komenda spawn", ["lobby"], false);
	}
	
	public function onCommand(CommandSender $sender, array $args) : void {
	    
		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}
		
		/*if($sender->hasPermission("ok.spawn.ignoretime")) {
			//$sender->teleport($sender->getWorld()->getSafeSpawn());
			$sender->sendMessage(Main::format("Przeteleportowano na spawna!"));
			return;
		}*/
		
		$nick = $sender->getName();

		$time = 10;

		$sender->sendMessage(Main::format("Teleportacja nastapi za §9$time §7sekund, nie ruszaj sie!"));
		
		$sender->addEffect(new EffectInstance(Effect::getEffect(9), 20*$time, 3));

        if(isset(Main::$spawnTask[$nick]))
            Main::$spawnTask[$nick]->cancel();

        Main::$spawnTask[$nick] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new SpawnTask($sender, 10), 20);
			
		
	}
}