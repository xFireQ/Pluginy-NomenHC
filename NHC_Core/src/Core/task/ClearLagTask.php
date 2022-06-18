<?php

namespace Core\task;

use pocketmine\scheduler\Task;

use pocketmine\Server;

use Core\Main;

class ClearLagTask extends Task {

	private $time;
	private $d_time;

	public function __construct(int $time){
		$this->time = $time + 1;
		$this->d_time = $time + 1;
	}

	public function onRun(): void{
		$this->time--;

		if($this->time == 15)
			$this->sendTip("§r§7Itemy zostana usuniete za §915 §7sekund§8!");

		if($this->time <= 3 && $this->time > 0)
			$this->sendTip("§r§7Itemy zostana usuniete za §9{$this->time} §7sekundy§8!");

		if($this->time <= 0){
			$this->time = $this->d_time;

			Main::getInstance()->clearLag();
		}
	}
	
	private function sendTip(string $msg) : void {
		foreach(Server::getInstance()->getOnlinePlayers() as $p)
		 $p->sendTip($msg);
	}
}