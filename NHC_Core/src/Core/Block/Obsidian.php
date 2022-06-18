<?php

namespace Core\block;


use pocketmine\block\Block;
use pocketmine\block\GlowingObsidian;

class Obsidian extends Block {

	public function getBlastResistance() : float {
		return 43;
	}
}