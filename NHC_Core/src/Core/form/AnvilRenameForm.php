<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\TieredTool;
use Core\Main;
use pocketmine\Server;

class AnvilRenameForm extends Form {

    public function __construct() {
    	
        $data = [
            "type" => "custom_form",
            "title" => "§r§9§lKowadlo",
            "content" => []
        ];
        
		//$data["content"][] = ["type" => "input", "text" => "§8» §7Podaj nazwe itemu\n"];
        
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
		$nick = $player->getName();
		$item = $player->getInventory()->getItemInHand();
		
		if ($data === null) return;
			 
        if($data[0]) {
            $player->setXpLevel($player->getXpLevel() - 50);
            $item->setCustomName("§r§f" . $data[0]);
            $player->getInventory()->setItemInHand($item);
            $player->sendMessage(Main::format("Pomyslnie zmieniono nazwe itemu na §r§9". $data[0]));
        } else {
            $player->sendMessage(Main::format("Musisz podac nazwe itemu!"));
        }
   }
}