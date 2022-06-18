<?php

declare(strict_types=1);

namespace Core\command\commands\admin;


use pocketmine\command\{
	Command, CommandSender
};


use pocketmine\utils\Config;

use Core\command\BaseCommand;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;

use Core\manager\WebhookManager;

use Core\webhhok\Webhook;
use Core\webhook\types\Message;
use Core\webhook\types\Embed;

use Core\Main;

class KickCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("kick", "komenda kick", [], false, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
      
      if(empty($args)) {
           $sender->sendMessage(Main::format("Poprawne uzycie to §9/kick §8[§9nick§8]"));
      }
      
      if(isset($args[0])) {
           $player = $sender->getServer()->getPlayerExact($args[0]);
           
           if($player === null) {
                $sender->sendMessage(Main::format("Takiego gracza nie ma na serwerze"));
                return;
           }
           
           $player->kick("§7Zostales wyrzucony przez administratora §9{$sender->getName()}§7!", false);
           
           $sender->sendMessage(Main::format("Pomyslnie wyrzucono §9{$player->getName()}§7!"));
           
           
         }
     }
 }