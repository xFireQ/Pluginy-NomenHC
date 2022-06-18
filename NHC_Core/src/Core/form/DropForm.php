<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\utils\Utils;
use Core\settings\SettingsManager;
use Core\Main;

class DropForm extends Form {

    public function __construct() {
    
        
    	
        $data = [
            "type" => "form",
            "title" => "§r§2§lDROP",
		    "content" => "",
		     "buttons" => []
	
        ];

        //$data["content"][] = ["type" => "label", "text" => "§7Ogolne ustawienia"];
        
        $data["buttons"][] = ["text" => "Drop z CobbleX", "image" => ["type" => "path", "data" => "textures/blocks/cobblestone_mossy"]];
        
        $data["buttons"][] = ["text" => "Drop z Stone", "image" => ["type" => "path", "data" => "textures/items/diamond_pickaxe"]];
        $data["buttons"][] = ["text" => "Drop z Pandory", "image" => ["type" => "path", "data" => "textures/blocks/dragon_egg"]];
       
        
       
        
        
        
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
    	$formData = json_decode($data);
		
		if($formData === null) return;
		
		$nick = $player->getName();
		
		
		
		switch($formData) {
		    case "0":
		        
		    break;
		    
			case "1":
			 $player->sendForm(new DropStoneForm($player));
			break;
        
    }
   }
}