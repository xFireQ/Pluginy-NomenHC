<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\utils\Utils;
use Core\settings\SettingsManager;
use Core\Main;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;


class SettingsForm extends Form {

    public function __construct(Player $player) {
    
            $value = SettingsManager::getValue($player);
    	
    	    
    	
        $data = [
            "type" => "custom_form",
            "title" => "§r§c§lUSTAWIENIA",
            "content" => []
        ];

        $data["content"][] = ["type" => "label", "text" => "§7Ogolne ustawienia"];
        
        /*if($value == "true") {
       	$data["content"][] = ["type" => "toggle", "text" => "§r§2UI§8/§2GUI",  "default" => true];
        } else {
            $data["content"][] = ["type" => "toggle", "text" => "§r§2UI§8/§2GUI",  "default" => false];
        }*/
        
       	
        
       
        
        
        
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
    	

       //$formData = json_decode($data);
		
		//if($data === null) return;
		
		$nick = $player->getName();
		
		if ($data === null // player clicks the x button
         or $data[0] === "" // player submit an empty text
      ) {
         
         return;
      }
		
		
			 if($data[1] === true) {
               SettingsManager::setTrue($player);
               $player->sendForm(new SettingsForm($player));
        return;
        	
        } else {
          SettingsManager::setFalse($player);
            $player->sendForm(new SettingsForm($player));
        return;
        }
        
        
        
   }
}