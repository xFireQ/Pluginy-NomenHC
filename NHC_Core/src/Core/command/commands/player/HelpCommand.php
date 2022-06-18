<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use Core\user\User;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use Core\command\BaseCommand;

use pocketmine\player\Player;

use Core\Main;

class HelpCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("pomoc", "komenda pomoc", ["help", "?"], false);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	//$user = $sender;
 	
 	 $sender->sendMessage("§7============ §8[ §9§lPOMOC §r§8] §7============");
 	 $sender->sendMessage("§7Dostepne komendy§8: \n§9/drop§r §8- §7wyswietla ustawienia dropu ");
 	 $sender->sendMessage("§9/ustawienia§r §8- §7wyswietla ogolne ustawienia");
 	 $sender->sendMessage("§9/helpop§r §8- §7zglasza gracza");
 	 $sender->sendMessage("§9/administracja§r §8- §7sprawdza administracje");
 	 $sender->sendMessage("§9/schowek§r §8- §7wyswietla schowek");
 	 $sender->sendMessage("§9/list§r §8- §7pokazuje liste graczy");
 	 $sender->sendMessage("§9/plecak§r §8- §7wyswietla plecak");
 	 $sender->sendMessage("§9/spawn§r §8- §7teleportuje na spawn");
     $sender->sendMessage("§9/g§r §8- §7pomoc gildii");
     $sender->sendMessage("§9/kit§r §8- §7otwiera menu z kitami");
     $sender->sendMessage("§9/tpa§r §8- §7teleportacja do drugiego gracza");
     $sender->sendMessage("§9/efekty§r §8- §7otwiera sie menu z efektami");

     $sender->sendMessage("§7============ §8[ §9§lPOMOC §r§8] §7============");
 	 
 	// foreach ($messages as $message) {
 	 //$sender->sendMessage($message);
 	 
 	 
 	 //$item = \pocketmine\item\ItemFactory::getInstance()->get(52, 0, 1);
 	// $item->setCustomName("§r§9RZUCAK");
 	 //$item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
 	// $sender->getInventory()->addItem($item);
 }
 
  
}