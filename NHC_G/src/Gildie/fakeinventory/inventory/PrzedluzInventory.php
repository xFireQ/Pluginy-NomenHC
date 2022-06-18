<?php

declare(strict_types=1);

namespace Gildie\fakeinventory\inventory;

use Gildie\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\block\Block;
use pocketmine\inventory\Inventory;
use Gildie\Main;

class PrzedluzInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        $nick = $player->getName();
        $guildManager = Main::getInstance()->getGuildManager();
        
        $guild = $guildManager->getPlayerGuild($nick);
        
        $tag = $guild->getTag();
        
        parent::__construct($player, "§l§9PANEL §r§8- [§l§9" . $tag . "§r§8]");
        
        

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $sender = $player;
        $this->clearAll();
        
        $guildManager = Main::getInstance()->getGuildManager();
        
        
        $guild = $guildManager->getPlayerGuild($sender->getName());
        
        $tag = $guild->getTag();
        $name = $guild->getName();
        $leader = $guild->getLeader();
        $lifes = $guild->getLifes();
        $expiryDate = $guild->getExpiryDate();
        $points = $guild->getPoints();
        $rankPlace = $guild->getRankPlace();

        $expiryH = 0;
        $expiryM = 0;
        $expiryS = 0;

        if(!$guild->canConquer()) {
            $exipiryTime = strtotime($guild->getConquerDate()) - time();

            $expiryH = floor($exipiryTime / 3600);
            $expiryM = floor(($exipiryTime / 60) % 60);
            $expiryS = $exipiryTime % 60;
        }

        $members = "";

        foreach($guild->getPlayers() as $nick) {
            $Fnick = $nick;

            if($nick === $guild->getLeader() || $nick === $guild->getOfficer())
                $Fnick = "§l".$Fnick;

            if($sender->getServer()->getPlayerExact($nick))
                $members .= "§a".$Fnick."§r§8, ";
            else
                $members .= "§c".$Fnick."§8, ";
        }

        $members = substr($members, 0, strlen($members) - 2);

        $alliances = "";

        foreach($guild->getAlliances() as $tag) {
            $aGuild = $guildManager->getGuildByTag($tag);

            $alliances .= "§8[§6{$aGuild->getTag()}§8] §6{$aGuild->getName()}§7, ";
        }

        if($alliances === "")
            $alliances = "§cBRAK";
        else
            $alliances = substr($alliances, 0, strlen($alliances) - 2);

       /* $sender->sendMessage(" \n§8          §2LightPE\n\n");
        $sender->sendMessage("§8§l»§r §7Tag: §8[§2{$tag}§8]");
        $sender->sendMessage("§8§l»§r §7Nazwa:§2 $name");
        $sender->sendMessage("§8§l»§r §7Zalozyciel:§2 $leader");
        $sender->sendMessage("§8§l»§r §7Ranking: §2$points");
        $sender->sendMessage("§8§l»§r §7Miejsce w rankingu: §2$rankPlace");
        $sender->sendMessage("§8§l»§r §7Zycia: §2$lifes");
        $sender->sendMessage("§8§l»§r §7Mozna podbic za: §2$expiryH §7godzin, §2$expiryM §7minut i §2$expiryS §7sekund");
        $sender->sendMessage("§8§l»§r §7Waznosc: §2$expiryDate");
        $sender->sendMessage("§8§l»§r §7Czlonkowie: $members");
        $sender->sendMessage("§8§l»§r §7Sojusze: $alliances");
        $sender->sendMessage(" \n");*/
    
        
        $info = \pocketmine\item\ItemFactory::getInstance()->get(339, 0, 1);
        $info->setCustomName("§r§l§9GILDIA §r§8[§9{$tag}§8] - [§9{$name}§8]");
        $info->setLore(["§r§8» §7Gildia wygasa: §9". $expiryDate]);
        //$item->setLore(["§r§8» §7Lider: §c{$leader} \n§r§8» §7Zycia: §c{$lifes} \n§r§8» §7Ranking:§c {$points} \n§r§8» §7Czlonkowie: {$members} \n§r§8» §7Soujsze: {$alliances}"]);
        $itemB = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS);
        $itemE = \pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64);
        
        $tak = \pocketmine\item\ItemFactory::getInstance()->get(35, 5, 1);
        $tak->setCustomName("§r§l§9PRZEDLUZ GILDIE");
        $tak->setLore(["§r§8» §7Potrzebujesc §964§7 emeraldow do przedluzenia gildi",
        "§r§8» §7W ekwipunku posiadasz §9" . $this->getItemCount($player->getInventory(), $itemE) . "§7emeraldow"]);
        
        $zarzadzaj = \pocketmine\item\ItemFactory::getInstance()->get(397, 3, 1);
        $zarzadzaj->setCustomName("§r§l§9ZARZADZAJ CZLONKAMI");
        $powieksz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_INGOT);
        $powieksz->setCustomName("§r§l§9POWIEKSZ GILDIE");
        $przedluz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT);
        $przedluz->setCustomName("§r§l§9PRZEDLUZ GILDIE");
        
        $cofnij = \pocketmine\item\ItemFactory::getInstance()->get(399, 0, 1);
        $cofnij->setCustomName("§r§l§cCOFNIJ");
        
        for($i = 1; $i < 10; $i++) {
            $this->setItemAt($i, 1, $itemB);
            $this->setItemAt($i, 3, $itemB);
        }
        
        for($i = 1; $i < 4; $i++) {
            $this->setItemAt(1, $i, $itemB);
            $this->setItemAt(9, $i, $itemB);
        }
        
        $this->setItemAt(4, 2, $tak);
        $this->setItemAt(6, 2, $info);
        $this->setItemAt(9, 3, $cofnij);
       // $this->setItemAt(5, 3, $zarzadzaj);
        //$this->setItemAt(4, 5, $przedluz);
    // $this->setItemAt(6, 5, $powieksz);
     

    
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        $sender = $player;
        $guildManager = Main::getInstance()->getGuildManager();

        $nick = $sender->getName();
        
        
        if($item->getId() == 399) {
           // $sender = $player;
            $this->changeInventory($player, new PanelInventory($player));
        }
        
        if($item->getId() == 35) {
           // $sender = $player;
            
            $guild = $guildManager->getPlayerGuild($nick);

        if(!$sender->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64))) {
            $sender->sendMessage(Main::format("Do przedluzenia gildii potrzebujesz 64 emeraldow"));
            return true;
        }

        $sender->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64));

        $date = date_create($guild->getExpiryDate());
        date_add($date,date_interval_create_from_date_string("1 days"));
        $guild->setExpiryDate(date_format($date,"d.m.Y H:i:s"));

        $sender->sendMessage(Main::format("Pomyslnie przedluzono waznosc gildii o 1 dzien!"));
            
        }
        
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