<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;
use Core\Main;

class VillagerMenuInventory extends FakeInventory {

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9VILLAGER");
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        //§8»

        $this->setItemAt(5, 1, \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PAPER)->setCustomName("§r§l§6INFORMACJE")->setLore([
            "§r§7§r§8» §7Tutaj wymienisz odlamki na unikatowy item!",
            "§r§8» §7Jak zdobyc odlamek?",
            "§r§8» §7Po zabojstwie gracza wypada od §61§8-§63 §7odlamlow"
        ]));
        $this->setItemAt(3, 2, \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_PICKAXE)->setCustomName("§r§l§6KILOF 6/3/3")->setLore([
            "§r§8» §7Aby zdobyc kilof potrzebujesz §640 odlamkow",
            "§r§8» §r§7Kliknij §6LPM §7aby zakupic!"
        ]));
        $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_PICKAXE)->setCustomName("§r§l§6KILOF 10/3/3")->setLore([
            "§r§8» §7Aby zdobyc kilof potrzebujesz §6128 odlamkow",
            "§r§8» §7Po wymianie otrzymasz najszybszy kilof na serwerze",
            "§r§8» §r§7Kliknij §6LPM §7aby zakupic!"
        ]));
        $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DRAGON_EGG)->setCustomName("§r§l§3PANDORA")->setLore([
            "§r§8» §7Aby zdobyc 16 pandor potrzebujesz §629 odlamkow",
            "§r§8» §r§7Kliknij §6LPM §7aby zakupic!"
        ])->setCount(16));
        $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DRAGON_EGG)->setCustomName("§r§l§3PANDORA")->setLore([
            "§r§8» §7Aby zdobyc 32 pandor potrzebujesz §664 odlamkow",
            "§r§8» §r§7Kliknij §6LPM §7aby zakupic!"
        ])->setCount(64));
        $this->setItemAt(7, 2, \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS)->setCustomName("§r§l§cSZYBKIE BUTY (niedostepne)")->setLore([
            "§r§8» §7Aby otrzymac super szybkie buty potrzebujesz §6190 odlamkow",
            "§r§8» §7Po zakupie otrzymasz buty szybkosci, po zalozeniu bedziesz posiadal nieskonczony §r§6efekt szybkosci II§r",
            "§r§8» §r§7Kliknij §6LPM §7aby zakupic!"
        ])->setCount(1));


        $this->fill();
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        /*if($sourceItem->getId() == \pocketmine\item\ItemIds::DIAMOND_BOOTS AND $slot === 15) {
            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 29))) {
                if ($player->getInventory()->canAddItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 29));
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_BOOTS, 0, 1);
                    $item->setCustomName("§r§l§cSzybkieButy");
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 10));
                    $player->getInventory()->addItem($item);
                    $player->sendMessage("§r§2§lGratulacje! §r§aOtrzymano super szybkie buty!");

                } else {
                    $player->sendMessage(Main::format("Nie posiadasz miejsca w ekwipunku!"));

                }
            } else {
                $player->sendMessage(Main::format("Nie posiadasz wystarczajacej liczby odlamkow!"));
            }
        }*/

        if($sourceItem->getId() == \pocketmine\item\ItemIds::DRAGON_EGG AND $slot === 14) {
            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 64))) {
                if ($player->getInventory()->canAddItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DRAGON_EGG))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 64));
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DRAGON_EGG, 0, 64);
                    $item->setCustomName("§r§l§3PANDORA");
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 10));
                    $player->getInventory()->addItem($item);
                    $player->sendMessage("§r§2§lGratulacje! §r§aOtrzymano 64x pandor!");

                } else {
                    $player->sendMessage(Main::format("Nie posiadasz miejsca w ekwipunku!"));

                }
            } else {
                $player->sendMessage(Main::format("Nie posiadasz wystarczajacej liczby odlamkow!"));
            }
        }

        if($sourceItem->getId() == \pocketmine\item\ItemIds::DRAGON_EGG AND $slot === 13) {
            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 29))) {
                if ($player->getInventory()->canAddItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DRAGON_EGG))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 29));
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DRAGON_EGG, 0, 16);
                    $item->setCustomName("§r§l§3PANDORA");
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 10));
                    $player->getInventory()->addItem($item);
                    $player->sendMessage("§r§2§lGratulacje! §r§aOtrzymano 16x pandor!");

                } else {
                    $player->sendMessage(Main::format("Nie posiadasz miejsca w ekwipunku!"));

                }
            } else {
                $player->sendMessage(Main::format("Nie posiadasz wystarczajacej liczby odlamkow!"));
            }
        }

        if($sourceItem->getId() == \pocketmine\item\ItemIds::DIAMOND_PICKAXE AND $slot === 11) {
            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 40))) {
                if ($player->getInventory()->canAddItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_PICKAXE))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 40));
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_PICKAXE, 0, 1);
                    $item->setCustomName("§r§l§6KILOF 6/3/3");
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FORTUNE), 3));
                    $player->getInventory()->addItem($item);
                    $player->sendMessage("§r§2§lGratulacje! §r§aOtrzymano super szybki kilof §8(§r§66§8/§63§8/§63§8)");

                } else {
                    $player->sendMessage(Main::format("Nie posiadasz miejsca w ekwipunku!"));

                }
            } else {
                $player->sendMessage(Main::format("Nie posiadasz wystarczajacej liczby odlamkow!"));
            }
        }

        if($sourceItem->getId() == \pocketmine\item\ItemIds::DIAMOND_PICKAXE AND $slot === 12) {
            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 128))) {
                if ($player->getInventory()->canAddItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_PICKAXE))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::PRISMARINE_SHARD, 0, 128));
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(ItemIds::DIAMOND_PICKAXE, 0, 1);
                    $item->setCustomName("§r§l§6KILOF 10/3/3");
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 10));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FORTUNE), 3));
                    $player->getInventory()->addItem($item);
                    $player->sendMessage("§r§2§lGratulacje! §r§aOtrzymales najszybszy kilof na serwerze §8(§r§610§8/§63§8/§63§8)");

                } else {
                    $player->sendMessage(Main::format("Nie posiadasz miejsca w ekwipunku!"));

                }
            } else {
                $player->sendMessage(Main::format("Nie posiadasz wystarczajacej liczby odlamkow!"));
            }
        }
        return true;
    }


}