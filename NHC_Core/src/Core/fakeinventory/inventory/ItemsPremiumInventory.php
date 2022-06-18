<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\player\Player;
use Core\drop\DropManager;
use pocketmine\block\Block;

class ItemsPremiumInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player,"§r§l§9ITEMy PREMIUM");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $enchant = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10);
        $eff_6 = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 7);
        $ub = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $fortuna = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        
        $pc = \pocketmine\item\ItemFactory::getInstance()->get(122, 0, 64);
        $pc->setCustomName("§r§9PANDORA x64");
        $pc->addEnchantment($enchant);

        $an = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_BOOTS);
        $an->setCustomName("§r§9AntyNogi");
        $an->addEnchantment($enchant);

        $bojka = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 64);
        $bojka->setCustomName("§r§9BoyFarmer");
        $bojka->addEnchantment($enchant);

        $kopacz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE, 0, 64);
        $kopacz->setCustomName("§r§9KopaczFosy");
        $kopacz->addEnchantment($enchant);

        $rzucak = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, 64);
        $rzucak->setCustomName("§r§9Rzucak x64");
        $rzucak->addEnchantment($enchant);

        $szostka = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE, 0, 1);
        $szostka->setCustomName("§r§9Kilof 6/3/3");
        $szostka->addEnchantment($eff_6);
        $szostka->addEnchantment($ub);
        $szostka->addEnchantment($fortuna);



        
        $this->setItemAt(1, 1, $pc);
        $this->setItemAt(2, 1, $an);
        $this->setItemAt(3, 1, $bojka);
        $this->setItemAt(4, 1, $kopacz);
        $this->setItemAt(5, 1, $rzucak);
        $this->setItemAt(6, 1, $szostka);

     

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $enchant = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10);
        $eff_6 = new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 7);
        $ub = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $fortuna = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        
        $pc = \pocketmine\item\ItemFactory::getInstance()->get(122, 0, 64);
        $pc->setCustomName("§r§c§lPANDORA");
        $pc->addEnchantment($enchant);

        $an = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_BOOTS);
        $an->setCustomName("§r§6§lAntyNogi");
        $an->addEnchantment($enchant);

        $bojka = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, 64);
        $bojka->setCustomName("§r§6BoyFarmer");
        $bojka->addEnchantment($enchant);

        $kopacz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE, 0, 64);
        $kopacz->setCustomName("§r§6KopaczFosy");
        $kopacz->addEnchantment($enchant);

        $rzucak = \pocketmine\item\ItemFactory::getInstance()->get(52, 0, 64);
        $rzucak->setCustomName("§r§l§cRzucak");
        $rzucak->addEnchantment($enchant);

        $szostka = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE, 0, 1);
        $szostka->setCustomName("§r§l§cKilof 6/3/3");
        $szostka->addEnchantment($eff_6);
        $szostka->addEnchantment($ub);
        $szostka->addEnchantment($fortuna);

        if($item->getId() == \pocketmine\item\ItemIds::OBSIDIAN) {
            $player->getInventory()->addItem($bojka);
        }

        if($item->getId() == \pocketmine\item\ItemIds::STONE) {
            $player->getInventory()->addItem($kopacz);
        }

        if($item->getId() == \pocketmine\item\ItemIds::TNT) {
            $player->getInventory()->addItem($rzucak);
        }

        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_PICKAXE) {
            $player->getInventory()->addItem($szostka);
        }

        if($item->getId() == \pocketmine\item\ItemIds::GOLD_BOOTS) {
            $player->getInventory()->addItem($an);
        }


                
        if($item->getId() == "122") {
            $player->getInventory()->addItem($pc);
        }
        return true;
    }
}