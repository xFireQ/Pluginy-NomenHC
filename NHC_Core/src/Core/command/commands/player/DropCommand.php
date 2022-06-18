<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use Core\command\BaseCommand;

use Core\fakeinventory\inventory\SejfInventory;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\StringTag;
use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;
use Core\form\DropForm;

use Core\fakeinventory\inventory\DropMenuInventory;

use Core\Main;

class DropCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("drop", "komenda drop", [], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
     (new DropMenuInventory($sender))->openFor([$sender]);
 	 
 	 
 }
 
  
}