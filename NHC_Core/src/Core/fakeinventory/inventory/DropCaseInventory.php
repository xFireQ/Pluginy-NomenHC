<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;
use pocketmine\event\inventory\InventoryTransactionEvent;

use pocketmine\item\enchantment\Enchantment;

use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\block\Block;

class DropCaseInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9DROP");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
         
         $prot_4 = new EnchantmentInstance(Enchantment::getEnchantment(0), 4);
	  		 	$unb_3 = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
	  		 	$sharp_5 = new EnchantmentInstance(Enchantment::getEnchantment(9), 5);
	  		 		$fire_aspect_2 = new EnchantmentInstance(Enchantment::getEnchantment(13), 2);
	  		 			$eff_5 = new EnchantmentInstance(Enchantment::getEnchantment(15), 5);
							$eff_7 = new EnchantmentInstance(Enchantment::getEnchantment(15), 7);


	  		 			$knockback_2 = new EnchantmentInstance(Enchantment::getEnchantment(12), 2);
	  		 			
	  		 			$bow = \pocketmine\item\ItemFactory::getInstance()->get(261, 0, 1);

			$bow->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(19), 5));
		//	$bow->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(20), 2));
			$bow->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(22), 1));
			 
			 $arrow = \pocketmine\item\ItemFactory::getInstance()->get(262);
			 
			 $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD);



                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 5));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::KNOCKBACK), 2));

	  		 			//itemy
	  		 			$helm = \pocketmine\item\ItemFactory::getInstance()->get(310, 0, 1);
	  		 			$helm->addEnchantment($prot_4);
	  		 			$helm->addEnchantment($unb_3);

	  		 			$klata = \pocketmine\item\ItemFactory::getInstance()->get(311, 0, 1);
	  		 			$klata->addEnchantment($prot_4);
	  		 			$klata->addEnchantment($unb_3);

	  		 			$spodnie = \pocketmine\item\ItemFactory::getInstance()->get(312, 0, 1);
	  		 			$spodnie->addEnchantment($prot_4);
	  		 			$spodnie->addEnchantment($unb_3);

	  		 			$buty = \pocketmine\item\ItemFactory::getInstance()->get(313, 0, 1);
	  		 			$buty->addEnchantment($prot_4);
	  		 			$buty->addEnchantment($unb_3);

							$kilof_s = \pocketmine\item\ItemFactory::getInstance()->get(278, 0, 1);
							$kilof_s->addEnchantment($eff_7);
							$kilof_s->addEnchantment($unb_3);

	  		 		 $miecz_sharp_fire = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1);
        
        $cx = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOSS_STONE);
        $a = \pocketmine\item\ItemFactory::getInstance()->get(48, 0, 1);
        $b = \pocketmine\item\ItemFactory::getInstance()->get(49, 0, 1);
        $c = \pocketmine\item\ItemFactory::getInstance()->get(49, 0, 1);
        $d = \pocketmine\item\ItemFactory::getInstance()->get(1, 0, 1);
        $e = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK);
        $f = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_BLOCK);
        $g = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BLOCK);
        $h = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD_BLOCK);
        $i = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENCHANTED_GOLDEN_APPLE);
        $j = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLDEN_APPLE);
        $k = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT);

        $this->setItemAt(1, 1, $cx);
        $this->setItemAt(2, 1, $k);
        $this->setItemAt(3, 1, $b);
        $this->setItemAt(4, 1, $c);
        $this->setItemAt(5, 1, $d);
        $this->setItemAt(6, 1, $e);
        $this->setItemAt(7, 1, $f);
        $this->setItemAt(8, 1, $g);
        $this->setItemAt(9, 1, $h);
        $this->setItemAt(1, 2, $i);
        $this->setItemAt(2, 2, $j);
        $this->setItemAt(3, 2, $helm);
        $this->setItemAt(4, 2, $klata);
        $this->setItemAt(5, 2, $spodnie);
        $this->setItemAt(6, 2, $buty);
        $this->setItemAt(7, 2, $miecz_sharp_fire);
        $this->setItemAt(8, 2, $item);
        $this->setItemAt(9, 2, $bow);



                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 5));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::KNOCKBACK), 2));

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        /*if($item->getId() == "278") {
    $this->openFakeInventory($player, new DropStoneInventory($player));
}*/
        return true;
    }
}