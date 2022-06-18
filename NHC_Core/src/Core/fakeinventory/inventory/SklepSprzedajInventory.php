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
use pocketmine\player\Player;
use Core\managers\SklepManager;

class SklepSprzedajInventory extends FakeInventory {

    public function __construct(Player $player) {
        $nick = $player->getName();
        $m = SklepManager::getMonety($nick);
        parent::__construct($player,"§r§l§9SKLEP", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

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

        $bow1= new EnchantmentInstance(Enchantment::getEnchantment(19), 5);
        $bow2 = new EnchantmentInstance(Enchantment::getEnchantment(20), 2);
        $bow3 = new EnchantmentInstance(Enchantment::getEnchantment(22), 1);
        $nick = $player->getName();
        $money = SklepManager::getMonety($nick);
        $oakMoney = $money + 1.99;


        $this->oak = \pocketmine\item\ItemFactory::getInstance()->get(17, 0, 64)->setCustomName("§r§l§9DRZEWO")->setLore([
            "§r§8» §7Potrzebujesz §964 DRZEWA §7aby sprzedac",
            "§r§8» §7Po sprzedaniu tego itemu otrzymasz §91.99 monet§7!",
            "§r§8» §7Bedziesz posiadal §9{$oakMoney}",
            "§r§8» §r§7Kiknij §9LPM§7 aby zakupic"]);

        $back = \pocketmine\item\ItemFactory::getInstance()->get(399, 0, 1);

        $back->setCustomName("§r§8» §l§9Cofnij");

        $this->setItemAt(9, 6, $back);
        $this->setItemAt(2, 2, $this->oak);

        //$this->fillBars();
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $nick = $player->getName();
        
        
        $prot_4 = new EnchantmentInstance(Enchantment::getEnchantment(0), 4);
        $unb_3 = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $sharp_5 = new EnchantmentInstance(Enchantment::getEnchantment(9), 5);
        $fire_aspect_2 = new EnchantmentInstance(Enchantment::getEnchantment(13), 2);
        $eff_5 = new EnchantmentInstance(Enchantment::getEnchantment(15), 5);
        $eff_6 = new EnchantmentInstance(Enchantment::getEnchantment(15), 6);
        $bow1 = new EnchantmentInstance(Enchantment::getEnchantment(22), 1);
        $bow2 = new EnchantmentInstance(Enchantment::getEnchantment(20), 2);

        $knockback_2 = new EnchantmentInstance(Enchantment::getEnchantment(12), 2);

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

        $miecz_sharp_fire = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1);
        $miecz_sharp_fire->addEnchantment($sharp_5);
        $miecz_sharp_fire->addEnchantment($fire_aspect_2);

        $miecz_sharp_knock = \pocketmine\item\ItemFactory::getInstance()->get(276, 0, 1);
        $miecz_sharp_knock->addEnchantment($sharp_5);
        $miecz_sharp_knock->addEnchantment($knockback_2);

        $kilof = \pocketmine\item\ItemFactory::getInstance()->get(278, 0, 1);
        $kilof->addEnchantment($eff_5);
        $kilof->addEnchantment($unb_3);

        $kilof6 = \pocketmine\item\ItemFactory::getInstance()->get(278, 0, 1);
        $kilof6->addEnchantment($eff_6);
        $kilof6->addEnchantment($unb_3);

        $siekiera = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_AXE);
        $siekiera->addEnchantment($eff_5);
        $siekiera->addEnchantment($unb_3);

        $shovel = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_SHOVEL);
        $shovel->addEnchantment($eff_5);
        $shovel->addEnchantment($unb_3);

        $bow = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOW);
        $bow->addEnchantment($bow1);
        $bow->addEnchantment($bow2);
        
        if($item->getId() === 399) {

             $this->openFakeInventory($player, new SklepInventory($player));

        }

        switch(true) {
             
            case $item->equalsExact($this->oak):
                //$this->openFakeInventory($player, new ShopMenuInventory());
                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::LOG, 0, 64))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::LOG, 0, 64));
                   // $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::LOG, 0, 64));
                   $m = 1.99;
                   SklepManager::addMoney($nick, $m);

                    $player->sendMessage(Main::format("Pomyslnie sprzedano ten item!"));
                    $this->setItems($player);
                    $this->unClickItem($player);

                } else {
                    $player->sendMessage(Main::format("Nie posiadasz wystaraczajacej liczby drzewa aby zakupic ten item"));
                }
                break;
        }
        return true;
    }
}