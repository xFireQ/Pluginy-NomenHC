<?php

namespace Core\command\commands\player;

use pocketmine\{
    Server, Player
};

use pocketmine\command\{
	Command, CommandSender
};

use Core\command\BaseCommand;

use Core\Main;

class RepairCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("repair", "Komenda repair", ["napraw"], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

	        if(!$sender instanceof Player) {
            	$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
            	return;
            }

	        if(empty($args)) {
 		    $item = $sender->getInventory()->getItemInHand();
 	  	    $sender->getInventory()->setItemInHand($item->setDamage(0));
 	  	    $sender->sendMessage("§7Item zostal naprawiony!");
 	  	    $sender->sendTitle("§9§lRepair", "§3Item zostal naprawiony");
 	  	    return;
 	  	}

 	  	switch($args[0]) {
 	  	    case "all":
 	  	        foreach($sender->getInventory()->getContents() as $slot => $item)
 	  	            $sender->getInventory()->setItem($slot, $item->setDamage(0));

 	  	        foreach($sender->getArmorInventory()->getContents() as $slot => $item)
                    $sender->getArmorInventory()->setItem($slot, $item->setDamage(0));

                $sender->sendMessage("§7Pomyslnie naprawiono wszystkie przedmioty!");
               $sender->sendTitle("§9§lRepair", "§3Wszystkie itemy zostaly naprawione");
 	  	    break;
 	  	    default:
 	  	        $sender->sendMessage(Main::format("Nieznany argument!"));
 	  	}
   }
}