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
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;


use pocketmine\player\Player;

use Core\manager\WebhookManager;

use Core\webhhok\Webhook;
use Core\webhook\types\Message;
use Core\webhook\types\Embed;

use Core\Main;

class VoucherCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("voucher", "komenda voucher", ["vo"], true, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	$player = $sender;
 	
 	if(empty($args)) {
 	    $player->sendMessage(Main::format("Poprawne uzycie to §9/voucher §8[§9vip§8/§9svip§8/§9sponsor§8]"));
 	}
 	
 	if(isset($args[0])) {
 	    if($args[0] === "vip") {
 	        $voucher = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOK);
        $voucher->setCustomName("§r§eVoucher na range §eVIP");
        $voucher->setLore(["§r§8» §7Po aktywowaniu voucher otrzymasz range §eVIP", 
        "§r§8» §7Voucher do uzytku §ejednorazowego§7!",
        "§r§7Kliknij §l§eLPM §r§7aby aktywowac!"]);
 	        $player->getInventory()->addItem($voucher);
 	    }
 	    
 	    if($args[0] === "svip") {
 	        $voucher = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOK);
        $voucher->setCustomName("§r§6Voucher na range §6SVIP");
        $voucher->setLore(["§r§8» §7Po aktywowaniu voucher otrzymasz range §6SVIP", 
        "§r§8» §7Voucher do uzytku §6jednorazowego§7!",
        "§r§7Kliknij §l§6LPM §r§7aby aktywowac!"]);
 	        $player->getInventory()->addItem($voucher);
 	    }
 	    
 	    if($args[0] === "sponsor") {
 	        $voucher = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOK);
        $voucher->setCustomName("§r§9Voucher na range §9SPONSOR");
        $voucher->setLore(["§r§8» §7Po aktywowaniu voucher otrzymasz range §9SPONSOR", 
        "§r§8» §7Voucher do uzytku §9jednorazowego§7!",
        "§r§7Kliknij §l§9LPM §r§7aby aktywowac!"]);
 	        $player->getInventory()->addItem($voucher);
 	    }
 	}
 	 
 }
 
  
}