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

use Core\guild\GuildManager;

use pocketmine\player\Player;

use Core\Main;

class InfoCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("info", "Sprawdza informacje o gildi", [], false);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	
 	 if(empty($args)) {
 	     $sender->sendMessage(Main::format("Poprawne uzycie to §2/info §8[§2TAG§8]"));
 	 }
 	 if(isset($args[0])) {
 	// $guild = GuildManager::getGuildByTag($player, $args[0]);
 	 
 	 
 	 if(GuildManager::isGuildExists($args[0])) {
 	  $gildia = GuildManager::getGuildPlayer($sender->getName());
          $nazwa = GuildManager::getGuildByTag($gildia);
          
 	 $leader = GuildManager::getLeader($gildia);
 	 
 	$sender->sendMessage("§7Gildia: §8[§2{$gildia}§8] - [§2{$nazwa}§8]");
 	 $sender->sendMessage("§7Lider: §2{$leader}");
 	 } else { 
 	     $sender->sendMessage(Main::format("Ta gildia nie istnieje"));
 	 }
 	 
 	  
 	 }
 }
 
  
}