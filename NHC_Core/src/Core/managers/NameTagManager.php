<?php

declare(strict_types=1);

namespace Core\managers;

use pocketmine\player\Player;
use Core\Main;

class NameTagManager {
	
	public static function updateNameTag(Player $player) : void {
	    $nametag = self::getNameTag($player);

	    if($nametag != null)
	        $player->setNameTag(self::getNameTag($player));
	}

	public static function getNameTag(Player $player) : ?string {
        $group = Main::getInstance()->getGroupManager()->getPlayer($player->getName())->getGroup();

        if($group == null || $group->getNameTag() == null)
            return null;

        return FormatManager::getFormat($player, $group->getNametag());
    }
}