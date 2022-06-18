<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\command\BaseCommand;

use pocketmine\player\Player;

use Core\form\SettingsForm;

use Core\Main;

class SettingsCommand extends BaseCommand {
    
 public function __construct() {
 	  parent::__construct("opcje", "komenda ustawienia", ["ustawienia"], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	 $sender->sendForm(new SettingsForm($player));
 	 
 	 
 	 
 	 //$sender->sendMessage($v);
 }
 
  
}