<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\utils\Config;

use Core\command\BaseCommand;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use Core\fakeinventory\inventory\KitInventory;

use pocketmine\player\Player;

use Core\Main;

class KitCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("kit", "komenda kit", ["kity"], false);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	//$player = $sender;
     (new KitInventory($sender))->openFor([$sender]);

 }
  
}