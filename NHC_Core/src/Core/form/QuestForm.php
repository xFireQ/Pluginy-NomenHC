<?php

namespace Core\form;

use pocketmine\player\Player;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\Armor;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\item\TieredTool;

use Core\Main;

class QuestForm extends Form {

    public function __construct(Player $player) {

        $data = [
            "type" => "form",
            "title" => "§l§bQUESTY",
            "content" => "",
            "buttons" => []
        ];
        $data["buttons"][] = ["text" => "§r§8» Zmien nazwe itemu \n §b50 XP LVL"];

        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {

        $formData = json_decode($data);

        if($formData === null) return;

        switch($formData) {
            case "0":

                break;
        }
    }
}