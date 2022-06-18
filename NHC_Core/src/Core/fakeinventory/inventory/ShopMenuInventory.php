<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\Main;
use Core\user\UserManager;
use Core\util\ChatUtil;
use Core\fakeinventory\FakeInventory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;

class ShopMenuInventory extends FakeInventory {

    public function __construct(Player $player) {

        parent::__construct($player, "§r§l§9SKLEP ZA EMERALDY", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);
        
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();

        $this->zapal = \pocketmine\item\ItemFactory::getInstance()->get(259, 0, 1)->setCustomName("§r§l§9ZAPALNICZKA")->setLore([
            "§r§8» §7Koszt: §916 emeraldow",
            "§r§8» §7Ilosc: §91",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->arrow = \pocketmine\item\ItemFactory::getInstance()->get(262, 0, 64)->setCustomName("§r§l§9STRZALY")->setLore([
            "§r§8» §7Koszt: §964 emeraldy",
            "§r§8» §7Ilosc: §964",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);


        $this->water = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::WATER)->setCustomName("§r§l§9WODA")->setLore([
            "§r§8» §7Koszt: §932 emeraldy",
            "§r§8» §7Ilosc: §91",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->oak = \pocketmine\item\ItemFactory::getInstance()->get(17, 0, 64)->setCustomName("§r§l§9DRZEWO")->setLore([
            "§r§8» §7Koszt: §964 emeraldy",
            "§r§8» §7Ilosc: §964",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->stone = \pocketmine\item\ItemFactory::getInstance()->get(1, 0, 64)->setCustomName("§r§l§9STONE")->setLore([
            "§r§8» §7Koszt: §932 emeraldy",
            "§r§8» §7Ilosc: §932",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->stonebrick = \pocketmine\item\ItemFactory::getInstance()->get(98, 0, 64)->setCustomName("§r§l§9STONE BRICK")->setLore([
            "§r§8» §7Koszt: §932 emeraldy",
            "§r§8» §7Ilosc: §932",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->lampe = \pocketmine\item\ItemFactory::getInstance()->get(124, 0, 64)->setCustomName("§r§l§9LAMPA")->setLore([
            "§r§8» §7Koszt: §932 emeraldy",
            "§r§8» §7Ilosc: §932",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->glass = \pocketmine\item\ItemFactory::getInstance()->get(20, 0, 64)->setCustomName("§r§l§9SZKLO")->setLore([
            "§r§8» §7Koszt: §932 emeraldy",
            "§r§8» §7Ilosc: §932",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        $this->wool = \pocketmine\item\ItemFactory::getInstance()->get(35, 0, 64)->setCustomName("§r§l§9WELNA")->setLore([
            "§r§8» §7Koszt: §932 emeraldy",
            "§r§8» §7Ilosc: §932",
            " ",
            "§r§8» §r§9Kiknij aby zakupic"]);

        for ($i = 0; $i < 13; $i++) {
            $this->dye = \pocketmine\item\ItemFactory::getInstance()->get(351, $i, 64)->setCustomName("§r§l§9KOLOR")->setLore([
                "§r§8» §7Koszt: §932 emeraldy",
                "§r§8» §7Ilosc: §932",
                " ",
                "§r§8» §r§9Kiknij aby zakupic"]);
            $this->setItem(28+$i, $this->dye);

        }


        $this->setItemAt(2, 2, $this->zapal);
        $this->setItemAt(3, 2, $this->arrow);
        $this->setItemAt(4, 2, $this->water);
        $this->setItemAt(5, 2, $this->oak);
        $this->setItemAt(6, 2, $this->stone);
        $this->setItemAt(7, 2, $this->stonebrick);
        $this->setItemAt(8, 2, $this->lampe);
        $this->setItemAt(2, 3, $this->glass);
        $this->setItemAt(3, 3, $this->wool);

        $this->fill();
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;

        if($item->getId() === ItemIds::DYE) {
            //$this->openFakeInventory($player, new ShopMenuInventory());
            if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(351, $sourceItem->getMeta(), 64));

                $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
            } else {
                $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
            }
        }


        switch(true) {

            case $item->equalsExact($this->wool):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(35, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;

            case $item->equalsExact($this->glass):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(20, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;

            case $item->equalsExact($this->lampe):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(124, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;

            case $item->equalsExact($this->stonebrick):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(98, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;



            case $item->equalsExact($this->stone):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(1, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;

            case $item->equalsExact($this->arrow):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(262, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;

            case $item->equalsExact($this->zapal):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 16))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 16));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(259, 0, 1));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;

            case $item->equalsExact($this->water):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 32));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::WATER));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;
            case $item->equalsExact($this->oak):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(388, 0, 64));
                    $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::LOG, 0, 64));

                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten item"));
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby emeraldow aby zakupic ten item"));
                }
                break;
        }
        return true;
    }
}