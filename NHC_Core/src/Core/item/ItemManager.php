<?php

namespace Core\item;

use pocketmine\block\BlockToolType;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIdentifier;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;

class ItemManager {
	public static function init() : void {
	 ItemFactory::getInstance()->register(new Bow(new ItemIdentifier(ItemIds::BOW, 0), "bow"), true);
	 ItemFactory::getInstance()->register(new GoldenApple(new ItemIdentifier(ItemIds::GOLDEN_APPLE, 0)), true);
	}
}