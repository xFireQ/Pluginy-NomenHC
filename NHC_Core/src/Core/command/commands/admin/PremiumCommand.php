<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use pocketmine\command\{
	Command, CommandSender
};

use Core\command\BaseCommand;

use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;
use Core\form\DropForm;

use Core\fakeinventory\inventory\ItemsPremiumInventory;

use Core\Main;

class PremiumCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("premium", "komenda premium", [], true, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;

 	    (new ItemsPremiumInventory($sender))->openFor([$sender]);
 	
 	 
 	 
 }
 
  
}