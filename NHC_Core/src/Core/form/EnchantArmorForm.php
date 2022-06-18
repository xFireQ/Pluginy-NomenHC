<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\Main as SkyBlock;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\Level;
use pocketmine\Server;

class EnchantArmorForm extends Form {

    public function __construct() {
    
        
    	
        $data = [
            "type" => "form",
            "title" => "§r§f§k|||  §r§9§lENCHANTING §r§f§k|||",
		    "content" => "",
		     "buttons" => []
	
        ];

        //$data["content"][] = ["type" => "label", "text" => "§7Ogolne ustawienia"];
        
        $data["buttons"][] = ["text" => "Ochrona"];
        $data["buttons"][] = ["text" => "Niezniszczalnosc"];
    
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
    	$formData = json_decode($data);
		
		if($formData === null) return;
		
		$nick = $player->getName();
		
		
		
		switch($formData) {
		    case 0:
			$player->sendForm(new EnchantOchronaForm($player));
            break;
            
            case 1:
			$player->sendForm(new EnchantUbForm($player));
            break;
    }
   }
}