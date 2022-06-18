<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;
use Core\managers\SklepManager;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\level;
use Core\Main;


use pocketmine\math\Vector3;

class SklepInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        $nick = $player->getName();
        $m = SklepManager::getMonety($nick);
        parent::__construct($player, "§r§l§9SKLEP");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        
        $res = Main::getInstance()->getDb()->query("SELECT * FROM sklep ORDER BY monety DESC LIMIT 10");
        $top = [];

        $i = 1;
        while($row = $res->fetchArray())
            $top[$i++] = [$row['nick'], $row['monety']];

        $content = "";

        for($i = 1; $i <= 10; $i++) {
            if(isset($top[$i]))
                $content .= "\n§r§9{$i}. §7Gracz §9{$top[$i][0]} §7monety §9".$top[$i][1];
            else
                $content .= "\n§r§9{$i}. §7BRAK";
        }
        
        $res2 = Main::getInstance()->getDb()->query("SELECT * FROM sklep ORDER BY wydane DESC LIMIT 10");
        $top2 = [];

        $i2 = 1;
        while($row2 = $res2->fetchArray())
            $top2[$i2++] = [$row2['nick'], $row2['wydane']];

        $content2 = "";

        for($i2 = 1; $i2 <= 10; $i2++) {
            if(isset($top2[$i2]))
                $content2 .= "\n§r§9{$i2}. §7Gracz §9{$top2[$i2][0]} §7wydane monety §9".$top2[$i2][1];
            else
                $content2 .= "\n§r§9{$i2}. §7BRAK";
        }
        
        $kup = \pocketmine\item\ItemFactory::getInstance()->get(351, 10, 1);
        $kup->setCustomName("§r§l§aKUP ITEMY");
        $sell = \pocketmine\item\ItemFactory::getInstance()->get(351, 1, 1);
        $sell->setCustomName("§r§l§9SPRZEDAJ ITEMY");
        
        $sklepEme = \pocketmine\item\ItemFactory::getInstance()->get(388, 0, 1);
        $sklepEme->setCustomName("§r§l§aSKLEP ZA EMERALDY");
        
        $wydane = \pocketmine\item\ItemFactory::getInstance()->get(397, 3, 1);
        $wydane->setCustomName("§r§l§9TOP WYDANE");
        $posiadane = \pocketmine\item\ItemFactory::getInstance()->get(397, 3, 1);
        $posiadane->setCustomName("§r§l§9TOP POSIADANE");
        $posiadane->setLore(["§r{$content}"]);
        $wydane->setLore(["§r{$content2}"]);
        
        $this->setItemAt(2, 2, $kup);
        $this->setItemAt(3, 2, $sell);
        $this->setItemAt(4, 2, $sklepEme);
        $this->setItemAt(6, 2, $posiadane);
        $this->setItemAt(7, 2, $wydane);
        $this->fill();
        

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;

        $gracz = $player;
		$nick = $player->getName();
		
		if($item->getId() == "351" && $item->getCustomName() === "§r§l§aKUP ITEMY") {
            $this->setItems($player);
            $this->unClickItem($player);
        }
        
        if($item->getId() == "351" && $item->getCustomName() === "§r§l§9SPRZEDAJ ITEMY") {
            $this->setItems($player);
            $this->unClickItem($player);
        }
        
        if($item->getId() == "388" && $item->getCustomName() === "§r§l§aSKLEP ZA EMERALDY") {
            $this->openFakeInventory($player, new ShopMenuInventory($player));
        }
        
        return true;
    }
}