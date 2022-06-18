<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use Core\fakeinventory\inventory\ShopMenuInventory;
use Core\fakeinventory\inventory\SklepInventory;
use Core\settings\SettingsManager;
use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\command\BaseCommand;

use pocketmine\player\Player;

use Core\form\SchowekForm;

use Core\Main;

class SklepCommand extends BaseCommand {
    
 public function __construct() {
 	  parent::__construct("sklep", "komenda sklep", [], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	$value = SettingsManager::getValue($player);
 	
 	if($value == "false") {
 	  //$sender->sendForm(new SForm($sender));
 	} else {
 	    //GUI
        (new ShopMenuInventory($sender))->openFor([$sender]);
 	}
 }
 
  
}