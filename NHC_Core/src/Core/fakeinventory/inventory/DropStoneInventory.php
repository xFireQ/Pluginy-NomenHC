<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use Core\fakeinventory\FakeInventorySize;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;
use Core\drop\Drop;
use Core\user\UserManager;
use Core\user\User;
use pocketmine\block\Block;

class DropStoneInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9DROP", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $user = UserManager::getUser($nick)->getDrop();
        
            if($player->hasPermission("NomenHC.drop.vip")) {
        $diamondG = "11.30";
        $goldG = "8.30";
        $emeG = "13.30";
        $zelazoG = "18.30";
        $perlyG = "5.30";
        $tntG = "2.30";
        $nicieG = "3.30";
        $szlamG = "1.30";
        $obsydianG = "10.30";
        $biblioteczkiG = "6.30";
        $jablkaG = "12.30";
        $coalG = "24.30";
        } elseif($player->hasPermission("NomenHC.drop.svip")) {
        $diamondG = "11.60";
        $goldG = "8.60";
        $emeG = "13.60";
        $zelazoG = "18.60";
        $perlyG = "5.60";
        $tntG = "2.60";
        $nicieG = "3.60";
        $szlamG = "1.60";
        $obsydianG = "10.60";
        $biblioteczkiG = "6.60";
        $jablkaG = "12.60";
        $coalG = "24.60";
        } elseif($player->hasPermission("NomenHC.drop.sponsor")) {
        $diamondG = "11.90";
        $goldG = "8.90";
        $emeG = "13.90";
        $zelazoG = "18.90";
        $perlyG = "5.90";
        $tntG = "2.90";
        $nicieG = "3.90";
        $szlamG = "1.90";
        $obsydianG = "10.90";
        $biblioteczkiG = "6.90";
        $jablkaG = "12.90";
        $coalG = "24.90";
              } else {
                  
        $diamondG = "11.0";
        $goldG = "8.0";
        $emeG = "13.0";
        $zelazoG = "18.0";
        $perlyG = "5.0";
        $tntG = "2.0";
        $nicieG = "3.0";
        $szlamG = "1.0";
        $obsydianG = "10.0";
        $biblioteczkiG = "6.0";
        $jablkaG = "12.0";
        $coalG = "24.0";

            }
        
        
        /*
        $diamond = round(rand(0, 10000) / 100, 2) < 11.0;
        $gold = round(rand(0, 10000) / 100, 2) < 8.0;
        $eme = round(rand(0, 10000) / 100, 2) < 13.0;
        $zelazo = round(rand(0, 10000) / 100, 2) < 18.0;
        $perly = round(rand(0, 10000) / 100, 2) < 5.0;
        $tnt = round(rand(0, 10000) / 100, 2) < 2.0;
        $nicie = round(rand(0, 10000) / 100, 2) < 3.0;
        $szlam = round(rand(0, 10000) / 100, 2) < 1.0;
        $obsydian = round(rand(0, 10000) / 100, 2) < 10.0;
        $biblioteczki = round(rand(0, 10000) / 100, 2) < 6.0;
        $jablka = round(rand(0, 10000) / 100, 2) < 12.0;
        $coal = round(rand(0, 10000) / 100, 2) < 24.0;
        */
        $cobble = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE);
        $cobble->setCustomName("§r§eCOBBLESTONE");
        $user->getCobblestone() == "on" ? $cobble->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §e100%"]) :  $cobble->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §e100%",
                "§r§7Kliknij §e§lLPM§r §7aby zmienic"]);
        
        $szlam = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SLIME_BALL);
        $szlam->setCustomName("§r§aSLIME");
        $user->getSzlam() == "on" ? $szlam->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §a{$szlamG}",
                        "§r§8» §7Rangi §aPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §a§lLPM§r §7aby zmienic"]) :  $szlam->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §a{$szlamG}",
                "§r§8» §7Rangi §aPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §a§lLPM§r §7aby zmienic"]);
        
        $nicie = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STRING);
        $nicie->setCustomName("§r§fNICIE");
        $user->getNicie() == "on" ? $nicie->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §f{$nicieG}",
                        "§r§8» §7Rangi §fPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §f§lLPM§r §7aby zmienic"]) :  $nicie->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §f{$nicieG}",
                "§r§8» §7Rangi §fPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §f§lLPM§r §7aby zmienic"]);
        
        
        $tnt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT);
        $tnt->setCustomName("§r§cTNT");
        $user->getTnt() == "on" ? $tnt->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §c{$tntG}",
                        "§r§8» §7Rangi §cPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §c§lLPM§r §7aby zmienic"]) :  $tnt->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §c{$tntG}",
                "§r§8» §7Rangi §cPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §c§lLPM§r §7aby zmienic"]);
        
        $perly = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL);
        $perly->setCustomName("§r§3PERLY");
        $user->getPerly() == "on" ? $perly->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §3{$perlyG}",
                        "§r§8» §7Rangi §3PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §3§lLPM§r §7aby zmienic"]) :  $perly->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §3{$perlyG}",
                "§r§8» §7Rangi §3PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §3§lLPM§r §7aby zmienic"]);
        
        $zelazo = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT);
        $zelazo->setCustomName("§r§7ZELAZO");
        $user->getZelazo() == "on" ? $zelazo->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §7{$zelazoG}",
                        "§r§8» §7Rangi §7PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §7§lLPM§r §7aby zmienic"]) :  $zelazo->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §7{$zelazoG}",
                "§r§8» §7Rangi §7PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §7§lLPM§r §7aby zmienic"]);
        
        $obsydian = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN);
        $obsydian->setCustomName("§r§5OBSYDIAN");
        $user->getObsydian() == "on" ? $obsydian->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §5{$obsydianG}",         "§r§8» §7Rangi §5PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §5§lLPM§r §7aby zmienic"]) :  $obsydian->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §5{$obsydianG}",
                "§r§8» §7Rangi §5PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §5§lLPM§r §7aby zmienic"]);
        
        $biblioteczki = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOKSHELF);
        $biblioteczki->setCustomName("§r§6BIBLIOTECZKI");
        $user->getBiblioteczki() == "on" ? $biblioteczki->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §6{$biblioteczkiG}", 
                        "§r§8» §7Rangi §6PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §6§lLPM§r §7aby zmienic"]) :  $biblioteczki->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §6{$biblioteczkiG}",
                "§r§8» §7Rangi §6PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §6§lLPM§r §7aby zmienic"]);
        
        
        $jablka = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::APPLE);
        $jablka->setCustomName("§r§cJABLKA");
        $user->getJablka() == "on" ? $jablka->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §c{$jablkaG}",
                        "§r§8» §7Rangi §cPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §c§lLPM§r §7aby zmienic"]) :  $jablka->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §c{$jablkaG}",
                "§r§8» §7Rangi §cPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §c§lLPM§r §7aby zmienic"]);
        
        
        $diamond = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND);
        $diamond->setCustomName("§r§bDIAMENTY");
        $user->getDiamenty() == "on" ? $diamond->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §b{$diamondG}",
                        "§r§8» §7Rangi §bPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §b§lLPM§r §7aby zmienic"]) :  $diamond->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §b{$diamondG}",
        "§r§8» §7Rangi §bPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §b§lLPM§r §7aby zmienic"]);
        
        $gold = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_INGOT);
        $gold->setCustomName("§r§eZLOTO");
        $user->getZloto() == "on" ? $gold->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §e{$goldG}",
                        "§r§8» §7Rangi §ePREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §e§lLPM§r §7aby zmienic"]) :  $gold->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §e{$goldG}",
                "§r§8» §7Rangi §ePREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §e§lLPM§r §7aby zmienic"]);
        
        $emerald = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD);
        $emerald->setCustomName("§r§aEMERALDY");
        $user->getEmeraldy() == "on" ? $emerald->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §a{$emeG}",
                        "§r§8» §7Rangi §aPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §a§lLPM§r §7aby zmienic"]) :  $emerald->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §a{$emeG}",
                "§r§8» §7Rangi §aPREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §a§lLPM§r §7aby zmienic"]);
        
        $coal = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COAL);
        $coal->setCustomName("§r§8WEGIEL");
        $user->getWegiel() == "on" ? $coal->setLore(["§r§8» §7Aktywny: §aTAK",
                "§r§8» §7Szansa: §8{$coalG}",
                        "§r§8» §7Rangi §8PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §8§lLPM§r §7aby zmienic"]) :  $coal->setLore(["§r§8» §7Aktywny: §cNIE",
        "§r§8» §7Szansa: §8{$coalG}",
                "§r§8» §7Rangi §8PREMIUM §7maja powiekszony drop!",
        "§r§7Kliknij §8§lLPM§r §7aby zmienic"]);
        
        $itemOn = \pocketmine\item\ItemFactory::getInstance()->get(351, 10, 1);
        $itemOn->setCustomName("§r§aWlacz wszystkie itemy");
        $itemOn->setLore(["§r§7Kliknij §a§lLPM§r §7aby zmienic"]);
        
        $itemOff = \pocketmine\item\ItemFactory::getInstance()->get(351, 1, 1);
        $itemOff->setCustomName("§r§cWylacz wszystkie itemy");
        $itemOff->setLore(["§r§7Kliknij §c§lLPM§r §7aby zmienic"]);
        

        $this->setItemAt(2, 2, $diamond);
        $this->setItemAt(3, 2, $gold);
        $this->setItemAt(4, 2, $emerald);
        $this->setItemAt(5, 2, $zelazo);
        $this->setItemAt(5, 3, $coal);
        $this->setItemAt(6, 2, $perly);
        $this->setItemAt(7, 2, $obsydian);
        $this->setItemAt(8, 2, $coal);
        $this->setItemAt(2, 3, $tnt);
        $this->setItemAt(3, 3, $jablka);
        $this->setItemAt(4, 3, $biblioteczki);
        $this->setItemAt(8, 5, $cobble);
        $this->setItemAt(5, 3, $nicie);
        $this->setItemAt(6, 3, $szlam);
        $this->setItemAt(2, 5, $itemOn);
        $this->setItemAt(3, 5, $itemOff);

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $nick = $player->getName();
        $user = UserManager::getUser($nick)->getDrop();

        if($item->getId() === \pocketmine\item\ItemIds::DIAMOND) {
            if($user->getDiamenty() == "on") {
                $user->setDiamenty("off");
            } else {
                $user->setDiamenty("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::GOLD_INGOT) {
            if($user->getZloto() == "on") {
                $user->setZloto("off");
            } else {
                $user->setZloto("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::COBBLESTONE) {
            if($user->getCobblestone() == "on") {
                $user->setCobblestone("off");
            } else {
                $user->setCobblestone("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::EMERALD) {
            if($user->getEmeraldy() == "on") {
                $user->setEmeraldy("off");
            } else {
                $user->setEmeraldy("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::IRON_INGOT) {
            if($user->getZelazo() == "on") {
                $user->setZelazo("off");
            } else {
                $user->setZelazo("on");
            }
            $this->setItems($player);
        }
        
        if($item->getId() === \pocketmine\item\ItemIds::ENDER_PEARL) {
            if($user->getPerly() == "on") {
                $user->setPerly("off");
            } else {
                $user->setPerly("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::BOOKSHELF) {
            if($user->getBiblioteczki() == "on") {
                $user->setBiblioteczki("off");
            } else {
                $user->setBiblioteczki("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::STRING) {
            if($user->getNicie() == "on") {
                $user->setNicie("off");
            } else {
                $user->setNicie("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::SLIME_BALL) {
            if($user->getSzlam() == "on") {
                $user->setSzlam("off");
            } else {
                $user->setSzlam("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::TNT) {
            if($user->getTnt() == "on") {
                $user->setTnt("off");
            } else {
                $user->setTnt("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::APPLE) {
            if($user->getJablka() == "on") {
                $user->setJablka("off");
            } else {
                $user->setJablka("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::OBSIDIAN) {
            if($user->getObsydian() == "on") {
                $user->setObsydian("off");
            } else {
                $user->setObsydian("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === \pocketmine\item\ItemIds::COAL) {
            if($user->getWegiel() == "on") {
                $user->setWegiel("off");
            } else {
                $user->setWegiel("on");
            }
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        if($item->getId() === 351 && $item->getMeta() === 10) {
            //DropManager::setAllOn($player);
            $user->setAllOn();
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        
        if($item->getId() === 351 && $item->getMeta() === 1) {
            //DropManager::setAllOff($player);
            $user->setAllOff();
            $this->setItems($player);
            $this->unClickItem($player);

        }
        
        return true;
    }
}