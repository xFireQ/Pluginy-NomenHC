<?php

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

use Core\fakeinventory\inventory\OsInventory;

use Core\Main;

class OsCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("osiagniecia", "komenda osiagniecia", ["os"], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
     $sender->sendMessage(Main::format("Questy sa aktualnie §cwylaczone§8!"));
     return;

     //GUI
 	    (new OsInventory($sender))->openFor($sender);
 	
 	 
 	 
 }
 
  
}