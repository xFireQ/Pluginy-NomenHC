<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\player\Player;
use Core\Main;
use Core\drop\DropManager;
use pocketmine\block\Block;

class KitInventory extends FakeInventory {

    private $kits = [];

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9KITY", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $api = Main::getInstance()->getKitsAPI();

        $mieso = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COOKED_BEEF);

        $this->kits[] = "mieso";
        if(!$api->isCooldown($nick, "mieso")) {
            $mieso->setCustomName("§r§9§lKIT MIESO");
            $mieso->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $mieso->setCustomName("§r§9§lKIT MIESO");
            $mieso->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "mieso")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }
        $gracz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_PICKAXE);

        $this->kits[] = "gracz";
        if(!$api->isCooldown($nick, "gracz")) {
            $gracz->setCustomName("§r§9§lKIT GRACZ");
            $gracz->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $gracz->setCustomName("§r§9§lKIT GRACZ");
            $gracz->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "gracz")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }


        $ender = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_CHEST);

        $this->kits[] = "ender";
        if(!$api->isCooldown($nick, "ender")) {
            $ender->setCustomName("§r§9§lKIT ENDERCHEST");
            $ender->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $ender->setCustomName("§r§9§lKIT ENDERCHEST");
            $ender->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "ender")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }

        $vip = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_HELMET);

        $this->kits[] = "vip";
        if(!$api->isCooldown($nick, "vip")) {
            $vip->setCustomName("§r§9§lKIT VIP");
            $vip->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $vip->setCustomName("§r§9§lKIT VIP");
            $vip->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "vip")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }


        $svip = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_HELMET);

        $this->kits[] = "svip";
        if(!$api->isCooldown($nick, "svip")) {
            $svip->setCustomName("§r§9§lKIT SVIP");
            $svip->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $svip->setCustomName("§r§9§lKIT SVIP");
            $svip->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "svip")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }


        $sponsor = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_HELMET);

        $this->kits[] = "sponsor";
        if(!$api->isCooldown($nick, "sponsor")) {
            $sponsor->setCustomName("§r§9§lKIT SPONSOR");
            $sponsor->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $sponsor->setCustomName("§r§9§lKIT ENDERCHEST");
            $sponsor->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "sponsor")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }


        $yt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::LEATHER_CAP);

        $this->kits[] = "yt";
        if(!$api->isCooldown($nick, "yt")) {
            $yt->setCustomName("§r§9§lKIT YT");
            $yt->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $yt->setCustomName("§r§9§lKIT YT");
            $yt->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "yt")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }


        $ytp = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CHAIN_HELMET);

        $this->kits[] = "ytp";
        if(!$api->isCooldown($nick, "ytp")) {
            $ytp->setCustomName("§r§9§lKIT YT+");
            $ytp->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $ytp->setCustomName("§r§9§lKIT YT+");
            $ytp->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "ytp")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }

        $odlamki = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::PRISMARINE_SHARD);

        $this->kits[] = "odlamki";
        if(!$api->isCooldown($nick, "odlamki")) {
            $odlamki->setCustomName("§r§9§lKIT odlamki");
            $odlamki->setLore(["§r§8» §7Dostepny: §aTAK", "§r§8» §7Mozliwy do odebrania za §9§l00§r§8:§l§900§r§8:§l§900§r§8", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        } else {
            $odlamki->setCustomName("§r§9§lKIT odlamki");
            $odlamki->setLore(["§r§8» §7Dostepny: §cNIE", "§r§8» §7Mozliwy do odebrania za §9{$api->getCooldownFormat($nick, "odlamki")}", "§r§8» §7Kliknij §9LPM §7aby odebrac kita!"]);
        }

        $itemB = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS);
        $itemB->setCustomName(" ");
        $this->setItemAt(2, 2, $itemB);
        $this->setItemAt(2, 5, $itemB);
        $this->setItemAt(8, 2, $itemB);
        $this->setItemAt(8, 5, $itemB);


        for($i = 1; $i < 10; $i++) {
            $this->setItemAt($i, 1, $itemB);
            $this->setItemAt($i, 6, $itemB);
        }

        for($i = 1; $i < 7; $i++) {
            $this->setItemAt(1, $i, $itemB);
            $this->setItemAt(9, $i, $itemB);
        }


        $this->setItemAt(3, 3, $gracz);
        $this->setItemAt(5, 3, $ender);
        $this->setItemAt(7, 3, $mieso);
        $this->setItemAt(2, 4, $vip);
        $this->setItemAt(3, 4, $svip);
        $this->setItemAt(4, 4, $sponsor);
        $this->setItemAt(6, 4, $yt);
        $this->setItemAt(7, 4, $ytp);
        $this->setItemAt(5, 5, $odlamki);







    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;
        $enchant = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10);
        $eff_6 = new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 6);
        $ub = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $fortuna = new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3);
        $punch = new EnchantmentInstance(VanillaEnchantments::PUNCH(), 2);
        $falling = new EnchantmentInstance(VanillaEnchantments::FEATHER_FALLING(), 2);


        $nick = $player->getName();
        $api = Main::getInstance()->getKitsAPI();

        $diamond_helmet = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_HELMET, 0, 1);

        $diamond_helmet->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
        $diamond_helmet->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));

        $diamond_chestplate = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_CHESTPLATE, 0, 1);

        $diamond_chestplate->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
        $diamond_chestplate->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));

        $diamond_leggings = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_LEGGINGS, 0, 1);

        $diamond_leggings->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
        $diamond_leggings->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 2));

        $diamond_boots = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BOOTS, 0, 1);

        $diamond_boots->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
        $diamond_boots->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
        $diamond_boots->addEnchantment(new EnchantmentInstance(VanillaEnchantments::FEATHER_FALLING(), 2));

        $diamond_sword = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD, 0, 1);

        $diamond_sword->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 5));
        $diamond_sword->addEnchantment(new EnchantmentInstance(VanillaEnchantments::FIRE_ASPECT(), 2));

        $diamond_sword_k = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD, 0, 1);

        $diamond_sword_k->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 5));
        $diamond_sword_k->addEnchantment(new EnchantmentInstance(VanillaEnchantments::KNOCKBACK(), 2));
        $diamond_pickaxe = \pocketmine\item\ItemFactory::getInstance()->get(278, 0, 1);

        $diamond_pickaxe->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 5));
        $diamond_pickaxe->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));

        $bow = \pocketmine\item\ItemFactory::getInstance()->get(261, 0, 1);

        $bow->addEnchantment(new EnchantmentInstance(VanillaEnchantments::POWER(), 5));
        //PUNCH $bow->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(20), 2));
        $bow->addEnchantment(new EnchantmentInstance(VanillaEnchantments::INFINITY(), 1));
        $bow->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PUNCH(), 2));

        $arrow = \pocketmine\item\ItemFactory::getInstance()->get(262);

        $kit_gracz = array_search("gracz", $this->kits);
        $kit_vip = array_search("vip", $this->kits);
        $kit_svip = array_search("svip", $this->kits);
        $kit_sponsor = array_search("sponsor", $this->kits);
        $kit_ender = array_search("ender", $this->kits);
        $kit_yt = array_search("yt", $this->kits);
        $kit_ytp = array_search("ytp", $this->kits);
        $kit_mieso = array_search("mieso", $this->kits);




        if($item->getId() == \pocketmine\item\ItemIds::LEATHER_CAP) {

            if(!$player->hasPermission("NomenHC.kits.yt")) {
                $player->sendMessage("§r§8» §cNie posiadasz permisji aby odebrac tego kita!");
                $this->closeFor($player);

                return true;
            }

            if($api->isCooldown($nick, "yt")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }
            if(!$player->isOp()) {
                $api->setCooldown($nick, "yt", 60 * 480);

            }
            $koxy = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1);
            $refy = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 8);
            $perly = \pocketmine\item\ItemFactory::getInstance()->get(368, 0, 3);
            $snow = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SNOWBALL, 0, 16);
            $water = \pocketmine\item\ItemFactory::getInstance()->get(325, 8, 1);

            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }

            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);
        }



        if($item->getId() == \pocketmine\item\ItemIds::CHAIN_HELMET) {


            if(!$player->hasPermission("NomenHC.kits.ytp")) {
                $player->sendMessage("§r§8» §cNie posiadasz permisji aby odebrac tego kita!");
                $this->closeFor($player);

                return true;
            }

            if($api->isCooldown($nick, "ytp")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }
            if(!$player->isOp()) {
                $api->setCooldown($nick, "ytp", 60 * 960);
            }
            $koxy = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1);
            $refy = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 8);
            $perly = \pocketmine\item\ItemFactory::getInstance()->get(368, 0, 3);
            $snow = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SNOWBALL, 0, 16);
            $water = \pocketmine\item\ItemFactory::getInstance()->get(325, 8, 1);

            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $water, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }


            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $water, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }


            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);
        }

        if($item->getId() == \pocketmine\item\ItemIds::COOKED_BEEF) {

            if($api->isCooldown($nick, "mieso")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }

            $api->setCooldown($nick, "mieso", 60 * 2);
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COOKED_BEEF, 0, 64));
            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);

        }

        if($item->getId() == \pocketmine\item\ItemIds::PRISMARINE_SHARD) {
            if(!$player->hasPermission("NomenHC.kits.svip")) return true;

            if($api->isCooldown($nick, "odlamki")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }

            $api->setCooldown($nick, "odlamki", 60 * 240);
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::PRISMARINE_SHARD, 0, 6));
            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);

        }


        if($item->getId() == \pocketmine\item\ItemIds::STONE_PICKAXE) {

            if($api->isCooldown($nick, "gracz")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }

            $api->setCooldown($nick, "gracz", 60 * 5);
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_PICKAXE, 0, 1));
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COOKED_BEEF, 0, 64));
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::LOG, 0, 16));
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_CHEST, 0, 1));
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BUCKET, 8, 1));

            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->setItems($player);
            $this->closeFor($player);

        }

        if($item->getId() == \pocketmine\item\ItemIds::ENDER_CHEST) {

            if($api->isCooldown($nick, "ender")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }

            $api->setCooldown($nick, "ender", 60 * 30);
            $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_CHEST, 0, 1));

            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);
        }




        if($item->getId() == \pocketmine\item\ItemIds::IRON_HELMET) {


            if(!$player->hasPermission("NomenHC.kits.vip")) {
                $player->sendMessage("§r§8» §cNie posiadasz permisji aby odebrac tego kita!");
                $this->closeFor($player);

                return true;
            }

            if($api->isCooldown($nick, "vip")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }
            if(!$player->isOp()) {

                $api->setCooldown($nick, "vip", 60 * 480);
                //$api->setCooldown($nick, "vip", 60 * 2);

            }
            $koxy = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1);
            $refy = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 8);
            $perly = \pocketmine\item\ItemFactory::getInstance()->get(368, 0, 3);
            $snow = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SNOWBALL, 0, 16);
            $water = \pocketmine\item\ItemFactory::getInstance()->get(325, 8, 1);

            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $water, $snow, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }

            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);
        }



        if($item->getId() == \pocketmine\item\ItemIds::GOLD_HELMET) {


            if(!$player->hasPermission("NomenHC.kits.svip")) {
                $player->sendMessage("§r§8» §cNie posiadasz permisji aby odebrac tego kita!");
                $this->closeFor($player);

                return true;
            }

            if($api->isCooldown($nick, "svip")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }
            if(!$player->isOp()) {

                $api->setCooldown($nick, "svip", 60 * 960);
            }
            $koxy = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1);
            $refy = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 8);
            $perly = \pocketmine\item\ItemFactory::getInstance()->get(368, 0, 3);
            $snow = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SNOWBALL, 0, 16);
            $water = \pocketmine\item\ItemFactory::getInstance()->get(325, 8, 1);

            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $water, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }


            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $water, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }


            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);
        }



        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_HELMET) {


            if(!$player->hasPermission("NomenHC.kits.sponsor")) {
                $player->sendMessage("§r§8» §cNie posiadasz permisji aby odebrac tego kita!");
                $this->closeFor($player);

                return true;
            }

            if($api->isCooldown($nick, "sponsor")) {
                $player->sendMessage("§r§8» §cNie mozesz odebrac teraz tego kita, bedziesz mogl go odebrac pozniej!");
                $this->closeFor($player);
                return true;
            }
            if(!$player->isOp()) {

                $api->setCooldown($nick, "sponsor", 60 * 1920);
            }
            $koxy = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1);
            $refy = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 8);
            $perly = \pocketmine\item\ItemFactory::getInstance()->get(368, 0, 3);
            $snow = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SNOWBALL, 0, 16);
            $water = \pocketmine\item\ItemFactory::getInstance()->get(325, 8, 1);

            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }


            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }


            $items = [$diamond_helmet, $diamond_chestplate, $diamond_leggings, $diamond_boots, $diamond_sword, $diamond_sword_k, $koxy, $refy, $perly, $snow, $diamond_pickaxe, $bow, $arrow];

            foreach($items as $item) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($player->asVector3(), $item);
            }

            $player->sendMessage("§r§8» §aPomyslnie odebrano tego kita!");
            $this->closeFor($player);
        }


        return true;
    }
}