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

use pocketmine\player\Player;

use Core\Main;

class YtpCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("yt+", "komenda youtube+", ["youtube+"], false);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	//$player = $sender;
 	
 	 
 	 
 	 $sender->sendMessage("§7Ranga §9YouTube§b+ §7jest dostepna od §9300 subskrybcji");
 	 $sender->sendMessage("§7Wyswietlenia musza byc §9adekwatne §7do subskrybcji");
 	 $sender->sendMessage("§7Jesli spelniasz wymagania skonsultuj sie z §9administracja §7po przez discorda");
 	 
 	 
 }
 
  
}