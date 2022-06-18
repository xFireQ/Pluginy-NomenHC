<?php

declare(strict_types=1);

namespace Gildie\fakeinventory\inventory;

use Gildie\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\block\Block;
use Gildie\Main;
use Gildie\guild\GuildManager;
use pocketmine\inventory\Inventory;

class PermisjeInventory extends FakeInventory {

    private $nick;

    public function __construct(Player $player, string $nick) {
       // $playerN = $player->getName();
        parent::__construct($player, "§8» §7Gracz: §9§l". $nick);
        
        $this->nick = $nick;

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        //$item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK);
        $guildManager = Main::getInstance()->getGuildManager();
        
        $place = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE)->setCustomName("§r§9STAWIANIE BLOKOW")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_PLACE) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        $break = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE)->setCustomName("§r§9NISZCZENIE BLOKOW")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_BREAK) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        $tnt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT)->setCustomName("§r§9STAWIANIE TNT")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_TNT_PLACE) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        $tp = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL)->setCustomName("§r§9UZYWANIE TPACCEPT")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_TPACCEPT) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        $pvp = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_SWORD)->setCustomName("§r§9PERMISJE DO PVP")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_PVP) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        $chest1 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CHEST)->setCustomName("§r§9STAWIANIE/NISZCZENIE SKRZYN")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_PLACE_BREAK) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        $chest2 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CHEST)->setCustomName("§r§9OTWIERANIE SKRZYN")->setLore([$guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_OPEN) ? "§r§8» §7Ta permisje jest aktualnie §l§aWLACZONA" : "§r§8» §7Ta permisje jest aktualnie §l§cWYLACZONA", "§r§7Kliknij §l§9LPM §r§7aby zmienic"]);
        
        
        $this->setItem(0, $place);
        $this->setItem(1, $break);
        $this->setItem(2, $tnt);
        $this->setItem(3, $tp);
        $this->setItem(4, $pvp);
        $this->setItem(5, $chest1);
        $this->setItem(6, $chest2);
        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        $guildManager = Main::getInstance()->getGuildManager();
        
        $player_switch = $player->getServer()->getPlayerExact($this->nick);
        
        $nick = $this->nick;
        
        if($item->getId() == \pocketmine\item\ItemIds::CHEST) {
            if ($item->getCustomName() == "§r§9OTWIERANIE SKRZYN") {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_CHEST_OPEN);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_OPEN)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do otwierania Skrzyn");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do Otwierania Skrzyn");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do Otwierania Skrzyn");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do Otwierania Skrzyn");
                }
        } else {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_CHEST_PLACE_BREAK);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_PLACE_BREAK)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do Stawiania/Niszczenia skrzyn");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do Stawiania/Niszczenia Skrzyn");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do Stawiania/Niszczenia Skrzyn");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do Stawiania/Niszczenia Skrzyn");
                }
        }
        }
        
        
        
        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_SWORD) {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_PVP);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_PVP)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do pvp");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do pvp");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do pvp");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do pvp");
                }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::ENDER_PEARL) {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_TPACCEPT);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_TPACCEPT)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do /tpaccept");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do /tpaccept");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do /tpaccept");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do /tpaccept");
                }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::TNT) {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_TNT_PLACE);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_TNT_PLACE)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do stawiania tnt");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do stawiania tnt");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do stawiania tnt");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do stawiania tnt");
                }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_PICKAXE) {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_BLOCKS_BREAK);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_BREAK)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do niszczenia blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do niszczenia blokow");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do niszczenia blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do niszczenia blokow");
                }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::STONE) {
            $guildManager->switchPermission($nick, GuildManager::PERMISSION_BLOCKS_PLACE);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_PLACE)) {
                    $player->sendMessage("§r§8» §aNadano graczu {$nick} permisje do stawiania blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §aNadano ci permisje do stawiania blokow");
                } else {
                    $player->sendMessage("§8» §cOdebrano graczu {$nick} permisje do stawiania blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§8» §cOdebrano ci permisje do stawiania blokow");
                }
        }
        
        $this->setItems($player);
        
        return true;
    }
    
    public function getItemCount(Inventory $inventory, Item $item) : int {
        $count = 0;

        foreach($inventory->getContents() as $i) {
            if($i->equals($item)) {
                $count += $i->getCount();
            }
        }

        return $count;
    }
}