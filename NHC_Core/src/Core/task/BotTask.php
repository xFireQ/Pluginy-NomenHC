<?php

namespace Core\task;

use pocketmine\scheduler\Task;

use pocketmine\Server;

use pocketmine\utils\Config;

use Core\Main;

class BotTask extends Task {

	private $config;

	public function __construct(Config $config) {
		$this->config = $config;
	}

	public function onRun(): void {

		$msg = $this->config->get("messages")[mt_rand(0, count($this->config->get("messages")) - 1)];
		
		foreach(Server::getInstance()->getOnlinePlayers() as $p)
		 $p->sendMessage("§r§8[§9Nomen§fHC§r§8] §7".$msg);
	}
}