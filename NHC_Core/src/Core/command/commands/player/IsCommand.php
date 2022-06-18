<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\CommandSender;
use Core\fakeinventory\inventory\IsInventory;
use Core\utils\Utils;
use Core\command\BaseCommand;

use Core\Main;

class IsCommand extends BaseCommand {
    
 public function __construct() {
 	  parent::__construct("is", "komenda is", ["itemshop"], true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	
 	    //GUI
     (new IsInventory($sender))->openFor([$sender]);
 	}
}