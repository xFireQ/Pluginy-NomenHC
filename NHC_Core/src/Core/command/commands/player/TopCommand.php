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

use Core\fakeinventory\inventory\TopInventory;

use Core\Main;

class TopCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("top", "komenda top", ["topka"], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;

 	    //GUI
     (new TopInventory($sender))->openFor([$sender]);
 	 
 }
 
  
}