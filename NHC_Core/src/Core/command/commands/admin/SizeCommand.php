<?php

declare(strict_types=1);

namespace Core\command\commands\admin;


use pocketmine\command\{
	Command, CommandSender,
	ConsoleCommandSender
};


use pocketmine\utils\Config;

use Core\command\BaseCommand;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;

use Core\manager\WebhookManager;

use Core\user\UserManager;

use Core\webhhok\Webhook;
use Core\webhook\types\Message;
use Core\webhook\types\Embed;

use Core\Main;

class SizeCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("size", "komenda size", [], true, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	
 	 if(empty($args)) {
 	      $player->sendMessage(Main::format("Poprawne uzycie to §b/size §8[§bWIELKOSC§8]"));
 	 }
 	 
 	 if(isset($args[0])) {
 	      if(!is_numeric($args[0])) {
 	           $player->sendMessage(Main::format("Argument musi byc numeryczny"));
 	           return;
 	      }
 	      
 	      $int = (int)$args[0];
 	      
 	      if((int)$int) {
 	      
 	      $player->setScale($int);
 	      } else {
 	           $player->sendMessage(Main::format("Podano zly argument"));
 	      }
 	      
 	      
 	 }
 	 
 }
 
  
}