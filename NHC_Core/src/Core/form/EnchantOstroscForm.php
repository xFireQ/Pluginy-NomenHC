<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\Main as SkyBlock;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\level\Level;
use pocketmine\Server;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\EnchantmentInstance;

use pocketmine\block\Block;
use pocketmine\item\Pickaxe;
use pocketmine\item\{Arrow, Tool, Armor, Sword, ChainBoots, DiamondBoots, GoldBoots, IronBoots, LeatherBoots};

class EnchantOstroscForm extends Form {

    public function __construct() {
    
        $data = [
            "type" => "custom_form",
            "title" => "§r§f§k||| §r§9§lENCHANTING §r§f§k|||",
            "content" => []
        ];
        
        //$data["content"] = ["text" => "Elo"];

        $data["content"][] = ["type" => "slider", "text" => "§r§8» §9OSTROSC §8(§9I§8) - §710 poziom§7!\n§8» §9OSTROSC §8(§9II§8) - §715 poziom§7!\n§8» §9OSTROSC §8(§9III§8) - §720 poziom§7!\n§8» §9OSTROSC §8(§9IV§8) - §725 poziom§7!\n§8» §9OSTROSC §8(§9V§8) - §730 poziom§7!§r\n\n§8» §7Ostrosc§9", "min" => 1, "max" => 5];
        
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
    	$item = $player->getInventory()->getItemInHand();
    if ($data === null) return;
      
      
          if($data[0] == 0) {
              $player->sendMessage("§r§8» §7Nie mozesz zenchantowac tego itemu na §90 level§7!");
          } elseif($data[0] == 1) {
              if ($item instanceof Sword) {
              if($player->getXpLevel() >= 10) {
                        $ench1 = new EnchantmentInstance(Enchantment::getEnchantment(9), 1);
                        $item->addEnchantment($ench1);
                        $player->subtractXpLevels(10);
                        $player->getInventory()->setItemInHand($item);
                        $player->sendMessage("§8» §7Item zostal zenchantowany!");
              } else {
                  $player->sendMessage("§8»§7 Posiadasz zbyt maly level xp");
              }
              } else {
                  $player->sendMessage("§8» §7Nie mozesz zenchantowac tego itemu");
              }
                    } elseif($data[0] == 2) {
              if ($item instanceof Sword) {
              if($player->getXpLevel() >= 15) {
                        $ench1 = new EnchantmentInstance(Enchantment::getEnchantment(9), 2);
                        $item->addEnchantment($ench1);
                        $player->subtractXpLevels(15);
                        $player->getInventory()->setItemInHand($item);
                        $player->sendMessage("§8» §7Item zostal zenchantowany!");
              } else {
                  $player->sendMessage("§8»§7 Posiadasz zbyt maly level xp");
              }
                        //$player->sendMessage("§8»§7 Posiadasz zbyt maly level xp");
                    } else {
                        $player->sendMessage("§8» §7Nie mozesz zenchantowac tego itemu");
                    }
                    } elseif($data[0] == 3) {
              if ($item instanceof Sword) {
              if($player->getXpLevel() >= 20) {
                        $ench1 = new EnchantmentInstance(Enchantment::getEnchantment(9), 3);
                        $item->addEnchantment($ench1);
                        $player->subtractXpLevels(20);
                        $player->getInventory()->setItemInHand($item);
                        $player->sendMessage("§8» §7Item zostal zenchantowany!");
              } else {
                  $player->sendMessage("§8»§7 Posiadasz zbyt maly level xp");
              }
              } else {
                  $player->sendMessage("§8» §7Nie mozesz zenchantowac tego itemu");
              }
              
              
                    } elseif($data[0] == 4) {
              if ($item instanceof Sword) {
              if($player->getXpLevel() >= 25) {
                        $ench1 = new EnchantmentInstance(Enchantment::getEnchantment(9), 4);
                        $item->addEnchantment($ench1);
                        $player->subtractXpLevels(25);
                        $player->getInventory()->setItemInHand($item);
                        $player->sendMessage("§8» §7Item zostal zenchantowany!");
              } else {
                  $player->sendMessage("§8»§7 Posiadasz zbyt maly level xp");
              }
              } else {
                  $player->sendMessage("§8» §7Nie mozesz zenchantowac tego itemu");
              }
          } elseif($data[0] == 5) {
              if ($item instanceof Sword) {
              if($player->getXpLevel() >= 30) {
                        $ench1 = new EnchantmentInstance(Enchantment::getEnchantment(9), 5);
                        $item->addEnchantment($ench1);
                        $player->subtractXpLevels(30);
                        $player->getInventory()->setItemInHand($item);
                        $player->sendMessage("§8» §7Item zostal zenchantowany!");
              } else {
                  $player->sendMessage("§8»§7 Posiadasz zbyt maly level xp");
              }
              
              } else {
                  $player->sendMessage("§8» §7Nie mozesz zenchantowac tego itemu");
              }
          } else {
              $player->sendMessage("ERROR");

          }

          
   }
}