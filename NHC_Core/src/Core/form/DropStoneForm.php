<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\utils\Utils;
use Core\settings\SettingsManager;
use Core\Main;
use Core\drop\DropManager;

class DropStoneForm extends Form {

    public function __construct(Player $player) {
    
        
    	
        $data = [
            "type" => "form",
            "title" => "§r§2§lDROP",
		    "content" => "",
		     "buttons" => []
	
        ];
        $nick = $player->getName();

        /*
        $diamond = round(rand(0, 10000) / 100, 2) < 12.0;
        $gold = round(rand(0, 10000) / 100, 2) < 9.0;
        $eme = round(rand(0, 10000) / 100, 2) < 14.0;
        $zelazo = round(rand(0, 10000) / 100, 2) < 19.0;
        $perly = round(rand(0, 10000) / 100, 2) < 6.0;
        $tnt = round(rand(0, 10000) / 100, 2) < 2.0;
        $nicie = round(rand(0, 10000) / 100, 2) < 60.0;
        $szlam = round(rand(0, 10000) / 100, 2) < 26.0;
        $obsydian = round(rand(0, 10000) / 100, 2) < 11.0;
        $biblioteczki = round(rand(0, 10000) / 100, 2) < 7.0;
        $jablka = round(rand(0, 10000) / 100, 2) < 34.0;
        */
        
        DropManager::getStatus($nick, "diamenty") == "on" ? $data["buttons"][] = ["text" => "§rDiamenty §aON\n§rSzansa: §212", "image" => ["type" => "path", "data" => "textures/items/diamond"]] : $data["buttons"][] = ["text" => "§rDiamenty §cOFF\n§rSzansa: §212", "image" => ["type" => "path", "data" => "textures/items/diamond"]];
        
        DropManager::getStatus($nick, "emeraldy") == "on" ? $data["buttons"][] = ["text" => "§rEmeraldy §aON\n§rSzansa: §214", "image" => ["type" => "path", "data" => "textures/items/emerald"]] : $data["buttons"][] = ["text" => "§rEmeraldy §cOFF\n§rSzansa: §214", "image" => ["type" => "path", "data" => "textures/items/emerald"]];
        
        DropManager::getStatus($nick, "zloto") == "on" ? $data["buttons"][] = ["text" => "§rZloto §aON\n§rSzansa: §29", "image" => ["type" => "path", "data" => "textures/items/gold_ingot"]] : $data["buttons"][] = ["text" => "§rZloto §cOFF\n§rSzansa: §29", "image" => ["type" => "path", "data" => "textures/items/gold_ingot"]];
        
        DropManager::getStatus($nick, "zelazo") == "on" ? $data["buttons"][] = ["text" => "§rZelazo §aON\n§rSzansa: §219", "image" => ["type" => "path", "data" => "textures/items/iron_ingot"]] : $data["buttons"][] = ["text" => "§rZelazo §cOFF\n§rSzansa: §219", "image" => ["type" => "path", "data" => "textures/items/iron_ingot"]];
        
        DropManager::getStatus($nick, "perly") == "on" ? $data["buttons"][] = ["text" => "§rPerly §aON\n§rSzansa: §26", "image" => ["type" => "path", "data" => "textures/items/ender_pearl"]] : $data["buttons"][] = ["text" => "§rPerly §cOFF\n§rSzansa: §26", "image" => ["type" => "path", "data" => "textures/items/ender_pearl"]];
        
        DropManager::getStatus($nick, "tnt") == "on" ? $data["buttons"][] = ["text" => "§rTnt §aON\n§rSzansa: §22", "image" => ["type" => "path", "data" => "textures/items/tnt"]] : $data["buttons"][] = ["text" => "§rTnt §cOFF\n§rSzansa: §22", "image" => ["type" => "path", "data" => "textures/items/tnt"]];
        
        DropManager::getStatus($nick, "nicie") == "on" ? $data["buttons"][] = ["text" => "§rNicie §aON\n§rSzansa: §260", "image" => ["type" => "path", "data" => "textures/items/diamond"]] : $data["buttons"][] = ["text" => "§rNicie §cOFF\n§rSzansa: §260", "image" => ["type" => "path", "data" => "textures/items/string"]];
        
        DropManager::getStatus($nick, "obsydian") == "on" ? $data["buttons"][] = ["text" => "§rObsydian §aON\n§rSzansa: §211", "image" => ["type" => "path", "data" => "textures/blocks/obsidian"]] : $data["buttons"][] = ["text" => "§rObsydian §cOFF\n§rSzansa: §211", "image" => ["type" => "path", "data" => "textures/blocks/obsidian"]];
        
        DropManager::getStatus($nick, "szlam") == "on" ? $data["buttons"][] = ["text" => "§rSlimeBall §aON\n§rSzansa: §226", "image" => ["type" => "path", "data" => "textures/items/slimeball"]] : $data["buttons"][] = ["text" => "§rSlimeBall §cOFF\n§rSzansa: §226", "image" => ["type" => "path", "data" => "textures/items/slimeball"]];
        
        DropManager::getStatus($nick, "biblioteczki") == "on" ? $data["buttons"][] = ["text" => "§rBiblioteczki §aON\n§rSzansa: §27", "image" => ["type" => "path", "data" => "textures/blocks/bookshelf"]] : $data["buttons"][] = ["text" => "§rBiblioteczki §cOFF\n§rSzansa: §27", "image" => ["type" => "path", "data" => "textures/blocks/bookshelf"]];
        

        DropManager::getStatus($nick, "jablka") == "on" ? $data["buttons"][] = ["text" => "§rJablka §aON\n§rSzansa: §234", "image" => ["type" => "path", "data" => "textures/items/apple"]] : $data["buttons"][] = ["text" => "§rJablka §cOFF\n§rSzansa: §234", "image" => ["type" => "path", "data" => "textures/items/apple"]];
        
        DropManager::getStatus($nick, "cobblestone") == "on" ? $data["buttons"][] = ["text" => "§r§e§lCOBBLESTONE §aON", "image" => ["type" => "path", "data" => "textures/items/apple"]] : $data["buttons"][] = ["text" => "§r§l§eCOBBLESTONE §cOFF", "image" => ["type" => "path", "data" => "textures/blocks/cobblestone"]];
        
        
       
        
        
        
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
    	$formData = json_decode($data);
		
		if($formData === null) return;
		
		$nick = $player->getName();
		
		
		
		switch($formData) {
			case 0:
			 DropManager::switchDrop($nick, "diamenty");
			break;
			
			case 1:
			 DropManager::switchDrop($nick, "emeraldy");
			break;		
			
			case 2:
			 DropManager::switchDrop($nick, "zloto");
			break;		
			
			case 3:
			 DropManager::switchDrop($nick, "zelazo");
			break;		
			
			case 4:
			 DropManager::switchDrop($nick, "perly");
			break;		
			
			case 5:
			 DropManager::switchDrop($nick, "tnt");
			break;		
			
			case 6:
			 DropManager::switchDrop($nick, "nicie");
			break;			
			
			case 7:
			 DropManager::switchDrop($nick, "obsydian");
			break;		
			
			case 8:
			 DropManager::switchDrop($nick, "szlam");
			break;			
			
			case 9:
			 DropManager::switchDrop($nick, "biblioteczki");
			break;			
			
			case 10:
			 DropManager::switchDrop($nick, "jablka");
			break;			
			
			
			case 11:
			 DropManager::switchDrop($nick, "cobblestone");
			break;
        
    }
    $player->sendForm(new DropStoneForm($player));
   }
}