<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\player\Player;
use Core\user\SaveInventory;
use pocketmine\block\Block;

class BackupInventory extends FakeInventory {
    use SaveInventory;

    /** @var string[] */
    private $inventory_names;

    protected $name;
    private $args;

    public function __construct(Player $player, array $inventory_names, String $name, string $args) {
        $this->name = $name;
        $this->inventory_names = $inventory_names;
        $this->args = $args;
        parent::__construct($player, "§r§l§9BACKUP GRACZA", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
        $this->player = $player;
    }

    public function setItems(Player $player) : void {
        $player = $this->player;
        $name = $this->name;
        $args = $this->args;
        $nick = $player == null ? $args : $player->getName();
        $i = 0;
        $backup = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOB_HEAD, 3, 1);

        foreach($this->inventory_names as $inventory_name) {
             $backup->setCustomName("{$inventory_name}");
             $backup->setLore(["§r§8» §7ID:§9 $inventory_name",
                "§r§8» §7Backup gracza:§9 $nick",
                "§r§7Kliknij §9§lLPM§r§7 aby odebrac"]);
             $this->setItem($i, $backup);   
             $i++;
        }
       
        //$this->setItemAt(6, 1, $szostka);
        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        if($item->getId() == \pocketmine\item\ItemIds::MOB_HEAD) {
            $invName = $item->getCustomName();
            if($invName == null) return true;
            
            $player->getInventory()->setContents($this->getInventoryContents($player, "$invName"));
            //$this->setItems2();
        }
        return true;
    }
}