<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\block\Block;
use pocketmine\inventory\Inventory;
use Core\drop\DropManager;
use Core\managers\PlecakManager;
use Core\Main;

class PlecakMenuInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9PLECAK", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $diax = PlecakManager::getCountItem($nick, "diamenty");
        $gol = PlecakManager::getCountItem($nick, "zloto");
        $iro = PlecakManager::getCountItem($nick, "zelazo");
        $emeral = PlecakManager::getCountItem($nick, "emeraldy");
        $countPerly = PlecakManager::getCountItem($nick, "perly");
        $countTnt = PlecakManager::getCountItem($nick, "tnt");
        $countNicie = PlecakManager::getCountItem($nick, "nicie");
        $countSzlam = PlecakManager::getCountItem($nick, "szlam");
        $countObsydian = PlecakManager::getCountItem($nick, "obsydian");
        $countBiblioteczki = PlecakManager::getCountItem($nick, "biblioteczki");
        $countJablka = PlecakManager::getCountItem($nick, "jablka");
        $countWegiel = PlecakManager::getCountItem($nick, "wegiel");
        $countCobblestone = PlecakManager::getCountItem($nick, "cobblestone");
        $value = PlecakManager::getStatus($player);
        
        if(!$player->hasPermission("NomenHC.plecak.all")) {
            $countAll = 1024;
        } else {
            $countAll = "Nieskonczonosc";
        }
        
        
        
        
        $cobble = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE);
        $cobble->setCustomName("§r§eCOBBLESTONE");
        $cobble->setLore([
            "§r§7Ilosc cobble w plecaku: §e{$countCobblestone}", 
            "§r§7Maksymalna ilosc w plecaku: §e{$countAll}",
            "§r§7Kliknij §l§eLPM §r§7aby wyplacic"]);
        
        $szlam = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SLIME_BALL);
        $szlam->setCustomName("§r§aSlimeBall");
        $szlam->setLore([
            "§r§7Ilosc slimeball w plecaku: §a{$countSzlam}", 
            "§r§7Maksymalna ilosc w plecaku: §a{$countAll}",
            "§r§7Kliknij §l§aLPM §r§7aby wyplacic"]);
        
        
        $nicie = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STRING);
        $nicie->setCustomName("§r§fNicie");
        $nicie->setLore([
            "§r§7Ilosc nici w plecaku: §f{$countNicie}", 
            "§r§7Maksymalna ilosc w plecaku: §f{$countAll}",
            "§r§7Kliknij §l§fLPM §r§7aby wyplacic"]);
        
        
        $tnt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT);
        $tnt->setCustomName("§r§cTNT");
        $tnt->setLore([
            "§r§7Ilosc tnt w plecaku: §c{$countTnt}", 
            "§r§7Maksymalna ilosc w plecaku: §c{$countAll}",
            "§r§7Kliknij §l§cLPM §r§7aby wyplacic"]);
        
        
        $perly = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL);
        $perly->setCustomName("§r§3Perly");
        $perly->setLore([
            "§r§7Ilosc perel w plecaku: §3{$countPerly}", 
            "§r§7Maksymalna ilosc w plecaku: §3{$countAll}",
            "§r§7Kliknij §l§3LPM §r§7aby wyplacic"]);
        
        
        $zelazo = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT);
        $zelazo->setCustomName("§r§7Zelazo");
        $zelazo->setLore([
            "§r§7Ilosc zelaza w plecaku: §7{$iro}", 
            "§r§7Maksymalna ilosc w plecaku: §7{$countAll}",
            "§r§7Kliknij §l§7LPM §r§7aby wyplacic"]);
        
        
        $obsydian = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN);
        $obsydian->setCustomName("§r§5Obsydian");
        $obsydian->setLore([
            "§r§7Ilosc obsydianu w plecaku: §5{$countObsydian}", 
            "§r§7Maksymalna ilosc w plecaku: §5{$countAll}",
            "§r§7Kliknij §l§5LPM §r§7aby wyplacic"]);
        
        
        $biblioteczki = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOKSHELF);
        $biblioteczki->setCustomName("§r§6Biblioteczki");
        $biblioteczki->setLore([
            "§r§7Ilosc biblioteczek w plecaku: §6{$countBiblioteczki}", 
            "§r§7Maksymalna ilosc w plecaku: §6{$countAll}",
            "§r§7Kliknij §l§6LPM §r§7aby wyplacic"]);
        
        
        
        $jablka = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::APPLE);
        $jablka->setCustomName("§r§cJablka");
        $jablka->setLore([
            "§r§7Ilosc jablek w plecaku: §c{$countJablka}", 
            "§r§7Maksymalna ilosc w plecaku: §c{$countAll}",
            "§r§7Kliknij §l§cLPM §r§7aby wyplacic"]);
        
        
        
        $diamond = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND);
        $diamond->setCustomName("§r§bDiamenty");
        $diamond->setLore([
            "§r§7Ilosc diamentow w plecaku: §b{$diax}", 
            "§r§7Maksymalna ilosc w plecaku: §b{$countAll}",
            "§r§7Kliknij §l§bLPM §r§7aby wyplacic"]);
        
        
        $gold = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_INGOT);
        $gold->setCustomName("§r§eZloto");
        $gold->setLore([
            "§r§7Ilosc zlota w plecaku: §e{$gol}", 
            "§r§7Maksymalna ilosc w plecaku: §e{$countAll}",
            "§r§7Kliknij §e§lLPM §r§7aby wyplacic"]);
        
        
        $emerald = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD);
        $emerald->setCustomName("§r§aEmeraldy");
        $emerald->setLore([
            "§r§7Ilosc emeraldow w plecaku: §a{$emeral}", 
            "§r§7Maksymalna ilosc w plecaku: §a{$countAll}",
            "§r§7Kliknij §l§aLPM§r §7aby wyplacic"]);
        
        
        $coal = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COAL);
        $coal->setCustomName("§r§8Wegiel");
        $coal->setLore([
            "§r§7Ilosc wegla w plecaku: §8{$countWegiel}", 
            "§r§7Maksymalna ilosc w plecaku: §8{$countAll}",
            "§r§7Kliknij §l§8LPM §r§7aby wyplacic"]);
        
        $msg = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::PAPER);
        $msg->setCustomName("§r§c§lWiadomosci");
        if($value == "on") {
                       $msg->setLore(["§r§8» §cWlacza§8/§cwylacza §7wiadomosci o pelnym eq", 
                       "§r§8» §7Aktualnie: §awlaczone",
                       "§r§7Kliknij §cLPM §7aby wylaczyc"]);
                } else {
                    $msg->setLore(["§r§8» §cWlacza§8/§cwylacza §7wiadomosci o pelnym eq", 
                       "§r§8» §7Aktualnie: §cwylaczone",
                       "§r§7Kliknij §cLPM §7aby wlaczyc"]);
                }
            
        
        
        

        $this->setItemAt(2, 2, $diamond);
        $this->setItemAt(3, 2, $gold);
        $this->setItemAt(4, 2, $emerald);
        $this->setItemAt(5, 2, $zelazo);
        $this->setItemAt(5, 3, $coal);
        $this->setItemAt(6, 2, $szlam);
        $this->setItemAt(7, 2, $obsydian);
        $this->setItemAt(8, 2, $coal);
        $this->setItemAt(2, 3, $tnt);
        $this->setItemAt(3, 3, $jablka);
        $this->setItemAt(4, 3, $biblioteczki);
       // $this->setItemAt(7, 3, $cobble);
        $this->setItemAt(5, 3, $nicie);
       // $this->setItemAt(6, 3, $szlam);
        $this->setItemAt(2, 5, $msg);
     

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $nick = $player->getName();
        /*$countD = PlecakManager::getCountItem($nick, "diamenty");
        $countG = PlecakManager::getCountItem($nick, "zloto");
        $countI = PlecakManager::getCountItem($nick, "zelazo");
        $countE = PlecakManager::getCountItem($nick, "emeraldy");
        $countPerly = PlecakManager::getCountItem($nick, "perly");
        $countTnt = PlecakManager::getCountItem($nick, "tnt");
        $countNicie = PlecakManager::getCountItem($nick, "nicie");
        $countSzlam = PlecakManager::getCountItem($nick, "szlam");
        $countObsydian = PlecakManager::getCountItem($nick, "obsydian");
        $countBiblioteczki = PlecakManager::getCountItem($nick, "biblioteczki");
        $countJablka = PlecakManager::getCountItem($nick, "jablka");
        $countWegiel = PlecakManager::getCountItem($nick, "wegiel");
        $countCobblestone = PlecakManager::getCountItem($nick, "cobblestone");
        $value = PlecakManager::getStatus($player);*/

        
        if($item->getId() == \pocketmine\item\ItemIds::COBBLESTONE) {

            $countCobblestone = PlecakManager::getCountItem($nick, "cobblestone");
            if($countCobblestone >= 64) {
                PlecakManager::removeItem($nick, 64, "cobblestone");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 cobblestone z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE, 0, 64));

            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 cobblestone w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::COAL) {
            $countWegiel = PlecakManager::getCountItem($nick, "wegiel");
            if($countWegiel >= 64) {
                PlecakManager::removeItem($nick, 64, "wegiel");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 wegla z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COAL, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 wegla w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::APPLE) {
            $countJablka = PlecakManager::getCountItem($nick, "jablka");
            if($countJablka >= 64) {
                PlecakManager::removeItem($nick, 64, "jablka");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 jablek z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::APPLE, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 jablek w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::BOOKSHELF) {
            $countBiblioteczki = PlecakManager::getCountItem($nick, "biblioteczki");
            if($countBiblioteczki >= 64) {
                PlecakManager::removeItem($nick, 64, "biblioteczki");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 biblioteczek z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOKSHELF, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 biblioteczek w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::OBSIDIAN) {
            $countObsydian = PlecakManager::getCountItem($nick, "obsydian");
            if($countObsydian >= 64) {
                PlecakManager::removeItem($nick, 64, "obsydian");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 obsydianu z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 obsydianu w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::SLIME_BALL) {
            $countSzlam = PlecakManager::getCountItem($nick, "szlam");
            if($countSzlam >= 64) {
                PlecakManager::removeItem($nick, 64, "szlam");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 slime z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SLIME_BALL, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 slime w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::STRING) {
            $countNicie = PlecakManager::getCountItem($nick, "nicie");
            if($countNicie >= 64) {
                PlecakManager::removeItem($nick, 64, "nicie");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 nici z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STRING, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 nici w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::TNT) {
            $countTnt = PlecakManager::getCountItem($nick, "tnt");
            if($countTnt >= 64) {
                PlecakManager::removeItem($nick, 64, "tnt");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 tnt z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 tnt w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::ENDER_PEARL) {
            $countPerly = PlecakManager::getCountItem($nick, "perly");

            if($countPerly >= 64) {
                PlecakManager::removeItem($nick, 64, "perly");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 perel z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 perel w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND) {
            $countD = PlecakManager::getCountItem($nick, "diamenty");
            if($countD >= 64) {
                PlecakManager::removeItem($nick, 64, "diamenty");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 6 diamentow z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 diamentow w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::GOLD_INGOT) {
            $countG = PlecakManager::getCountItem($nick, "zloto");
            if($countG >= 64) {
                PlecakManager::removeItem($nick, 64, "zloto");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 zlota z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_INGOT, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 zlota w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::IRON_INGOT) {
            $countI = PlecakManager::getCountItem($nick, "zelazo");
            if($countI >= 64) {
                PlecakManager::removeItem($nick, 64, "zelazo");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 zelaza z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 zelaza w plecaku aby wyplacic"));
            }
        }
        
        if($item->getId() == \pocketmine\item\ItemIds::EMERALD) {
            $countE = PlecakManager::getCountItem($nick, "emeraldy");
            if($countE >= 64) {
                PlecakManager::removeItem($nick, 64, "emeraldy");
                $player->sendMessage(Main::format("Pomyslnie wyplacono 64 emeraldow z plecaka"));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, 64));
            } else {
                $player->sendMessage(Main::format("Musisz posiadac minimum 64 emeraldow w plecaku aby wyplacic"));
            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::PAPER) {
            $value = PlecakManager::getStatus($player);
            if($value == "on") {
                PlecakManager::setOff($nick);
            } else {
                PlecakManager::setOn($nick);
            }

        }
        $this->setItems($player);
        
        return true;
    }
}