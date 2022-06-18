<?php

declare(strict_types=1);

namespace Core\command\commands\admin;


use pocketmine\command\{
	Command, CommandSender,
	ConsoleCommandSender
};

use pocketmine\inventory\Inventory;
use pocketmine\item\Item;

use pocketmine\utils\Config;

use Core\command\BaseCommand;

use Core\util\ChatUtil;
use Core\settings\SettingsManager;

use pocketmine\player\Player;

use pocketmine\block\Block;
use pocketmine\Server;

use Core\managers\BackupManager;

use Core\Main;

class PcaseCommand extends BaseCommand {
 public function __construct() {
 	  parent::__construct("pcase", "komenda casegive", ["casegive", "pall"], false, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {
 	//$player = $sender;
 	
 	
 	 if(!isset($args[1])) {
            $sender->sendMessage(ChatUtil::format("Poprawne uzycie to: /casegive &8[%MALL&8/%MNICK&8] [%MILOSC&8]"));
            return;
        }

        if(!is_numeric($args[1])) {
            $sender->sendMessage(ChatUtil::format("Podana ilosc nie jest numerem!"));
            return;
        }
        
        if($args[1] >= 200) {
            $sender->sendMessage(ChatUtil::format("Podana ilosc jest zbyt wysoka!"));
            return;
        }

        $premiumCase = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DRAGON_EGG);
        $premiumCase->setCustomName("§r§3PANDORA");
        $premiumCase->setCount((int) $args[1]);

        if($args[0] === "all") {
            foreach($sender->getServer()->getOnlinePlayers() as $player) {
                if(!isset($args[2]) || $args[2] !== "true")
                    $player->sendMessage(ChatUtil::format("Caly serwer otrzymal %M" . $args[1] . " %CPremiumCase od administratora %M" . $sender->getName()));

                if($player->getInventory()->canAddItem($premiumCase))
                    $player->getInventory()->addItem($premiumCase);
                else
                    $player->getWorld()->dropItem($player, $premiumCase);
            }

            return;
        }

        $player = $sender->getServer()->getPlayerExact($args[0]);

        if(!$player) {
            $sender->sendMessage(ChatUtil::format("Ten gracz jest &coffline%C!"));
            return;
        }

        if($player->getInventory()->canAddItem($premiumCase))
            $player->getInventory()->addItem($premiumCase);
        else
            $player->getWorld()->dropItem($player, $premiumCase);

        $sender->sendMessage(ChatUtil::format("Dales %M" . $args[1] . " %CPremiumCase graczowi %M" . $player->getName()));

        if(!isset($args[2]) || $args[2] !== "true")
            $player->sendMessage(ChatUtil::format("Otrzymales %M" . $args[1] . " %CPremiumCase od administratora %M" . $sender->getName()));
    }
  
}