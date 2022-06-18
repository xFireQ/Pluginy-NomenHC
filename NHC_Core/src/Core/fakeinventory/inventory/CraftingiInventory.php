<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\crafting\CraftingManager;
use Core\fakeinventory\FakeInventory;
use Core\util\ChatUtil;
use Core\Main;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;
use pocketmine\item\ItemFactory;
use pocketmine\player\Player;

class CraftingiInventory extends FakeInventory {

    private $page = 1;

    private $pages = [];
    private $pagesItems = [];

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9CRAFTINGI ", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $this->setItemAt(1, 1, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::WOOL, 5)->setCustomName("§r§l§aNastepny"));
        $this->setItemAt(1, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::WOOL, 4)->setCustomName("§r§l§6??"));
        $this->setItemAt(1, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::WOOL, 14)->setCustomName("§r§l§cPoprzedni"));
        $this->setItemAt(1, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(1, 5, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(1, 6, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));

        $this->setItemAt(4, 1, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(5, 1, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(6, 1, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(4, 5, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(5, 5, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(6, 5, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(4, 6, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(6, 6, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(9, 1, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(9, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(9, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(9, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(9, 5, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));
        $this->setItemAt(9, 6, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS));


        if($this->page === 1) {
            $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(4, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(4, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(6, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(6, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(5, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE));
            $this->setItemAt(5, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND));

            $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::END_STONE);
            $item->setCustomName("§r§3Stoniarka§9 2s");
            $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

            $this->setItemAt(5, 6, $item);


        }

        if($this->page === 2) {
            $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(4, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(4, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(6, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(6, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(5, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));
            $this->setItemAt(5, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64));

            $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT);
            $item->setCustomName("§r§l§cRzucak");
            $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

            $this->setItemAt(5, 6, $item);


        }

        if($this->page === 3) {
            $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(4, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(4, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(6, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(6, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(5, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(5, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL));

            $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_CHEST);
            $item->setCustomName("§r§9EnderChest");
           // $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

            $this->setItemAt(5, 6, $item);


        }

        if($this->page === 4) {
            $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(4, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(4, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(6, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(6, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(5, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN));
            $this->setItemAt(5, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND));

            $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN);
            $item->setCustomName("§r§6BoyFarmer");
             $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

            $this->setItemAt(5, 6, $item);


        }

        if($this->page === 5) {
            $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(4, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(4, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(6, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(6, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(5, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));
            $this->setItemAt(5, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND));

            $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
            $item->setCustomName("§r§6KopaczFosy");
             $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

            $this->setItemAt(5, 6, $item);


        }

        if($this->page === 6) {
            $this->setItemAt(4, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(4, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(4, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(6, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(6, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(6, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(5, 2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(5, 4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK));
            $this->setItemAt(5, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STICK));

            $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BLAZE_ROD);
            $item->setCustomName("§r§6BlazeRod");
            $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

            $this->setItemAt(5, 6, $item);


        }



    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        if($sourceItem->getId() === \pocketmine\item\ItemIds::BLAZE_ROD) {
            if($this->page === 6) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BLAZE_ROD);
                $item->setCustomName("§r§6BlazeRod");
                $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK, 0, 8))
                    AND $player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STICK, 0, 1))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK, 0, 8));
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STICK, 0, 1));

                    $player->getInventory()->addItem($item);
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz itemow aby stworzyc ten item!"));
                }
            }
        }
        if($sourceItem->getId() === \pocketmine\item\ItemIds::STONE) {
            if($this->page === 5) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
                $item->setCustomName("§r§6KopaczFosy");
                $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE, 0, 8))
                    AND $player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 1))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE, 0, 8));
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 1));

                    $player->getInventory()->addItem($item);
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz itemow aby stworzyc ten item!"));
                }
            }
        }
        if($sourceItem->getId() === \pocketmine\item\ItemIds::OBSIDIAN) {
            if($this->page === 4) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN);
                $item->setCustomName("§r§6BoyFarmer");
                $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 8))
                    AND $player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 1))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 8));
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 1));

                    $player->getInventory()->addItem($item);
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz itemow aby stworzyc ten item!"));
                }
            }
        }
        if($sourceItem->getId() === \pocketmine\item\ItemIds::ENDER_CHEST) {
            if($this->page === 3) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_CHEST);
                if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 8))
                    AND $player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL, 0, 1))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 8));
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL, 0, 1));

                    $player->getInventory()->addItem($item);
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz itemow aby stworzyc ten item!"));
                }
            }
        }
        if($sourceItem->getId() === \pocketmine\item\ItemIds::TNT) {
            if($this->page === 2) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT);
                $item->setCustomName("§r§l§cRzucak");
                $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64*9))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64*9));

                    $player->getInventory()->addItem($item);
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz itemow aby stworzyc ten item!"));
                }
            }
        }
        if($sourceItem->getId() === \pocketmine\item\ItemIds::END_STONE) {
            if($this->page === 1) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::END_STONE);
                $item->setCustomName("§r§3Stoniarka§9 2s");
                $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE, 0, 8))
                AND $player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 1))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE, 0, 8));
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 1));

                    $player->getInventory()->addItem($item);
                } else {
                    $player->sendMessage(Main::format("Nie posiadasz itemow aby stworzyc ten item!"));
                }
            }
        }

        if($sourceItem->getId() === \pocketmine\item\ItemIds::WOOL AND $sourceItem->getMeta() === 5) {
            $maxPage = 6;
            if($maxPage <= $this->page) {
                $player->sendMessage(Main::format("Jestes juz na ostatniej stronie"));
            } else {
                $this->page++;
                $this->setItems($player);
            }
        }

        if($sourceItem->getId() === \pocketmine\item\ItemIds::WOOL AND $sourceItem->getMeta() === 14) {
            $minPage = 1;
            if($minPage >= $this->page) {
                $player->sendMessage(Main::format("Jestes juz na pierwszej stronie"));
            } else {
                $this->page--;
                $this->setItems($player);
            }
        }

        $this->setTitle("§r§l§9CRAFTINGI");
        return true;
    }
}