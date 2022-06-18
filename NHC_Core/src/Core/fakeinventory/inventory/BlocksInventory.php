<?php

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use Core\fakeinventory\FakeInventorySize;
use Core\format\Format;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\item\ItemFactory;
use pocketmine\item\ItemIds;

class BlocksInventory extends FakeInventory {
    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9BLOKI", FakeInventorySize::LARGE_CHEST, true);
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $diamond = ItemFactory::get(57, 0, 1);
        $diamond->setCustomName("§r§9Diamentowe bloki");
        $diamond->setLore([
            "§r§8» §7Zamienia diamenty na diamentowe bloki",
            "§r§8» §7Kliknij §9LPM §7aby zamienic na bloki"]);

        $emerald = ItemFactory::get(133, 0, 1);
        $emerald->setCustomName("§r§9Emeraldowe bloki");
        $emerald->setLore([
            "§r§8» §7Zamienia emeraldy na emeraldowe bloki",
            "§r§8» §7Kliknij §9LPM §7aby zamienic na bloki"]);

        $gold = ItemFactory::get(41, 0, 1);
        $gold->setCustomName("§r§9Zlote bloki");
        $gold->setLore([
            "§r§8» §7Zamienia zloto na zlote bloki",
            "§r§8» §7Kliknij §9LPM §7aby zamienic na bloki"]);

        $iron = ItemFactory::get(42, 0, 1);
        $iron->setCustomName("§r§9Zelazne bloki");
        $iron->setLore([
            "§r§8» §7Zamienia zelazo na zelazne bloki",
            "§r§8» §7Kliknij §9LPM §7aby zamienic na bloki"]);

        $this->setItemAt(2, 2, $diamond);
        $this->setItemAt(4, 2, $emerald);
        $this->setItemAt(6, 2, $gold);
        $this->setItemAt(8, 2, $iron);

        $this->fill(ItemIds::IRON_BARS);

    }
    public function onTransaction(\pocketmine\player\Player $player, Item $sourceItem, Item $targetItem, int $slot): bool
    {
        if($sourceItem->getId() === \pocketmine\item\ItemIds::DIAMOND_BLOCK) {
            $itemCount = $this->getItemCount($player->getInventory(), \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND));
            $itemNewCount = $itemCount / 9;
            $itemRemoveCount = $itemNewCount * 9;
            $itemDiamondCount = $itemNewCount-(int)$itemNewCount;
            $itemDiamondCount = $itemDiamondCount*10;
            $math = (int)$itemRemoveCount-(int)$itemDiamondCount;
            var_dump($math);

            $player->getInventory()->removeItem(ItemFactory::get(264, 0, $math));
            $player->getInventory()->addItem(ItemFactory::get(57, 0, (int)$itemNewCount));
            Format::sendMessage($player, 2, "Zamieniono &9".$itemCount." &7diamentow na &9".$itemNewCount." &7blokow diamentowych!");
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