<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\block\BLock;
use pocketmine\player\Player;
use Core\user\UserManager;
use Core\Main;

class OsInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9OSIAGNIECIA");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $name = $player->getName();
        $user = UserManager::getUser($name)->getOs();
        $stoneBreak = $user->getBreakStone();
        
        $stone = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone->setCustomName("§r§9WYKOPANY STONE");
        $stone->setLore(["§r§8» §7Wykopany stone: §9" . $stoneBreak]);
        
        $this->setItemAt(2, 2, $stone);
     

        
    }

    private function setItemsBreak(Player $player) : void {
        $name = $player->getName();
        $user = UserManager::getUser($name)->getOs();
        $stoneBreak = $user->getBreakStone();

        $stone = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone->setCustomName("§r§9500 STONE");
        $stone->setLore(["§r§8» §7Nagroda: §932 diamenty", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);

        $stone2 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone2->setCustomName("§r§91000 STONE");
        $stone2->setLore(["§r§8» §7Nagroda: §964 emeraldy", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);

        $stone3 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone3->setCustomName("§r§92000 STONE");
        $stone3->setLore(["§r§8» §7Nagroda: §93 cobblexy", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);

        $stone4 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone4->setCustomName("§r§95000 STONE");
        $stone4->setLore(["§r§8» §7Nagroda: §910 Pandor", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);

        $stone5 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone5->setCustomName("§r§910000 STONE");
        $stone5->setLore(["§r§8» §7Nagroda: §915 Pandor", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);

        $stone6 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone6->setCustomName("§r§950000 STONE");
        $stone6->setLore(["§r§8» §7Nagroda: §964 cobblexy", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);

        $stone7 = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE);
        $stone7->setCustomName("§r§950000 STONE");
        $stone7->setLore(["§r§8» §7Nagroda: §9Kilof 6/3/3", "§r§8» §7Wykopany stone: §9" . $stoneBreak, "§r§8» §7Kliknij §9LPM §7aby odebrac!"]);



        $this->setItemAt(2, 2, $stone);
        $this->setItemAt(3, 2, $stone2);
        $this->setItemAt(4, 2, $stone3);
        $this->setItemAt(5, 2, $stone4);
        $this->setItemAt(6, 2, $stone5);
        $this->setItemAt(7, 2, $stone6);
        $this->setItemAt(8, 2, $stone7);




    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $nick = $player->getName();
        $user = UserManager::getUser($nick)->getOs();

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§9WYKOPANY STONE") {
            $this->setItemsBreak($player);;
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§950000 STONE") {
            if($user->getBreakStone() >= 50000) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
                $item->setCustomName("§r§l§cKilof 6/3/3");
                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
                $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));

                $player->getInventory()->addItem($item);
            } else {
                $player->sendMessage(Main::format("Nie wykopales jeszcze §950000 STONE§7!"));
            }
            $this->setItemsBreak($player);;
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§910000 STONE") {
            if($user->getBreakStone() >= 10000) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DRAGON_EGG, 0, 15);
                $item->setCustomName("§r§3PANDORA");
                $player->getInventory()->addItem($item);
            } else {
                $player->sendMessage(Main::format("Nie wykopales jeszcze §910000 STONE§7!"));
            }
            $this->setItemsBreak($player);;
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§95000 STONE") {
            if($user->getBreakStone() >= 5000) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DRAGON_EGG, 0, 10);
                $item->setCustomName("§r§3PANDORA");
                $player->getInventory()->addItem($item);
            } else {
                $player->sendMessage(Main::format("Nie wykopales jeszcze §95000 STONE§7!"));
            }
            $this->setItemsBreak($player);;
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§92000 STONE") {
            if($user->getBreakStone() >= 2000) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(48, 0, 3);
                $player->getInventory()->addItem($item);
            } else {
                $player->sendMessage(Main::format("Nie wykopales jeszcze §92000 STONE§7!"));
            }
            $this->setItemsBreak($player);;
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§9500 STONE") {
            if($user->getBreakStone() >= 500) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND, 0, 32);
                $player->getInventory()->addItem($item);
            } else {
                $player->sendMessage(Main::format("Nie wykopales jeszcze §9500 STONE§7!"));
            }
            $this->setItemsBreak($player);;
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE AND $item->getCustomName() == "§r§91000 STONE") {
            if($user->stoneClaim())
            if($user->getBreakStone() >= 1000) {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, 64);
                $player->getInventory()->addItem($item);
                $user->setStoneClaim("1000");
            } else {
                $player->sendMessage(Main::format("Nie wykopales jeszcze §91000 STONE§7!"));
            }
            $this->setItemsBreak($player);;
        }
        
        if($item->getId() == "122") {
            $this->openFakeInventory($player, new DropCaseInventory($player));
        }
        return true;
    }
}