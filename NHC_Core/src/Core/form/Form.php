<?php

namespace Core\form;

use pocketmine\form\Form as IForm;

use pocketmine\player\Player;

class Form implements IForm {
	
	protected $data = [];
	
	public function handleResponse(Player $player, $data) : void {
		
	}
	
	public function jsonSerialize() {
		return $this->data;
	}
}