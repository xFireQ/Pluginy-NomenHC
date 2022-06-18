<?php

namespace Gildie\bossbar;

use pocketmine\player\Player;

class BossbarManager {
	
	private static $bossbar = [];
	
	public static function setBossbar(Player $player, Bossbar $bossbar) : void {
	}
	
	public static function unsetBossbar(Player $player) : void {
	}
	
	public static function getBossbar(Player $player) : ?Bossbar {
		return self::$bossbar[$player->getName()] ?? null;
	}
}