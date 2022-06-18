<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use Core\command\BaseCommand;

use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;
use Core\form\DropForm;

use Core\fakeinventory\inventory\PlecakMenuInventory;

use Core\Main;

class PlecakCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("plecak", "komenda plecak", ["backpack"], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	
 	    //GUI
     (new PlecakMenuInventory($sender))->openFor([$sender]);
 	
 	 
 	 
 }
 
  
}