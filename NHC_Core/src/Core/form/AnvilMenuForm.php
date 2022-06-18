<?php

namespace Core\form;

use pocketmine\player\Player;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\TieredTool;

use Core\Main;

class AnvilMenuForm extends Form {
	
	public function __construct(Player $player) {
		
		$data = [
		 "type" => "form",
		 "title" => "§l§9Kowadlo",
		 "content" => "§r§8» §7Twoj Level XP §9".$player->getXpLevel(),
		 "buttons" => []
		];
	    $data["buttons"][] = ["text" => "§r§8» Napraw item \n §930 XP LVL"];
	    $data["buttons"][] = ["text" => "§r§8» Napraw ubrana zbroje \n §970 XP LVL"];
	    //$data["buttons"][] = ["text" => "§r§8» Zmien nazwe itemu \n §950 XP LVL"];
	     
		$this->data = $data;
	}
	
	public function handleResponse(Player $player, $data) : void {
		
		$formData = json_decode($data);
		
		if($formData === null) return;
		
		switch($formData) {
			case "0":
                if ($player->getXpLevel() >= 30) {
                    $item = $player->getInventory()->getItemInHand();
                    $player->getInventory()->setItemInHand($item->setDamage(0));
                    $player->setXpLevel($player->getXpLevel() - 30);
                    $player->sendMessage(Main::format("§7Item zostal pomyslnie naprawiony!"));
                } else {
                    $player->sendMessage(Main::format("§7Nie posiadasz wystarczajacego poziomu!"));
                }
			break;
			case "1":
                if ($player->getXpLevel() >= 70) {
                    $i = 0;
                foreach ($player->getArmorInventory()->getContents() as $item) {
                    if ($item instanceof Armor) {
                        $i++;
                    }
                }
                if ($i >= 1) {
                foreach ($player->getArmorInventory()->getContents() as $index => $item) {
                            if ($item instanceof Armor) {
                                if ($item->getMeta() > 0) {
                                    $player->getArmorInventory()->setItem($index, $item->setDamage(0));
                                }
                            }
                        }
                   
                    $player->setXpLevel($player->getXpLevel() - 70);
                    $player->sendMessage(Main::format("Naprawiono ubrana zbroje!"));
                }
                }else {
                    $player->sendMessage(Main::format("§7Nie posiadasz wystarczajacego poziomu!"));
                }
			break;
			case "2":
                if ($player->getXpLevel() >= 50) {
                    $player->sendForm(new AnvilRenameForm());
                } else {
                    $player->sendMessage(Main::format("Potrzebujesz 50 poziomu, aby zmienic nazwe!"));
                }
			break;
		}
	}
}
//$player->removeWindow($inventoryAction->getInventory());