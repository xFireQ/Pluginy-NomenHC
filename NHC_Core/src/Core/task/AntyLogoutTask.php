<?php

namespace Core\task;

use pocketmine\scheduler\Task;

use pocketmine\Server;


use Core\Main;

class AntyLogoutTask extends Task {

	public function onRun(): void {
		foreach(Main::$antylogoutPlayers as $nick => $time){
			$player = Server::getInstance()->getPlayerExact($nick);

			if(time() - $time >= Main::ANTYLOGOUT_TIME){
				
				unset(Main::$antylogoutPlayers[$nick]);
				Main::$assists[$nick] = [];
				$player->sendTitle("§l§9AntyLogout", "§7Walka dobiegla konca mozesz sie wylogowac!");
				
				return;
			}

			$player->sendTip("§9ANTYLOGOUT §8» §f".(Main::ANTYLOGOUT_TIME - (time() - $time)));
		}
	}
}