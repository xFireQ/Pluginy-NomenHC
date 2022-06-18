<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
	Command, CommandSender
};

use Core\api\Webhook;
use Core\api\Message;
use Core\api\Embed;

use pocketmine\utils\Config;

use Core\utils\Utils;
use Core\command\BaseCommand;

use pocketmine\player\Player;

use Core\form\HelpopForm;

use Core\Main;

class HelpopCommand extends BaseCommand {
    
 public function __construct() {
 	  parent::__construct("helpop", "zglasza gracza", ["zglos"], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	 $sender->sendForm(new HelpopForm($player));
 	 
 	 
 	 
 	 //$sender->sendMessage($v);
 }
 
  
}