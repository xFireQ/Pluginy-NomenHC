<?php

namespace Core\Block;

use pocketmine\block\Block;
use pocketmine\block\BlockBreakInfo;
use pocketmine\block\BlockFactory;
use pocketmine\block\BlockIdentifier;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\ItemIds;

class BlockManager {
	public static function init() : void {
	 
	// BlockFactory::getInstance()->register(new Obsidian(VanillaBlocks::OBSIDIAN(), "Obsidian", BlockBreakInfo::instant(ItemIds::DIAMOND_PICKAXE)), true);
	}
}