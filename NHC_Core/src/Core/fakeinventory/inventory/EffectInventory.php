<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use Core\Main;

class EffectInventory extends FakeInventory {
    

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9EFEKTY", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {

        $haste = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
        $haste->setCustomName("§r§9§lHASTE I");
        $haste->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §932 emeraldy§8!"]); 
        $this->setItemAt(2, 2, $haste);

         $haste = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
        $haste->setCustomName("§r§9§lHASTE II");
        $haste->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §964 emeraldy§8!"]); 
        $this->setItemAt(2, 3, $haste);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MAGMA_CREAM);
        $efekt->setCustomName("§r§9§lODPORNOSC NA OGIEN I");
        $efekt->setLore(["§r§8» §7Czas trwania: §95 minut§8!", "§r§8» §7Koszt: §932 emeraldy§8!"]); 
        $this->setItemAt(2, 4, $efekt);
     
        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SUGAR);
        $efekt->setCustomName("§r§9§lSPEED I");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §932 emeraldy§8!"]); 
        $this->setItemAt(4, 2, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SUGAR);
        $efekt->setCustomName("§r§9§lSPEED II");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §964 emeraldy§8!"]); 
        //$this->setItemAt(4, 3, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SUGAR);
        $efekt->setCustomName("§r§9§lSPEED III");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §9128 emeraldy§8!"]); 
       // $this->setItemAt(4, 4, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::FEATHER);
        $efekt->setCustomName("§r§9§lJUMP BOOST I");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §932 emeraldy§8!"]); 
        $this->setItemAt(6, 2, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::FEATHER);
        $efekt->setCustomName("§r§9§lJUMP BOOST II");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §964 emeraldy§8!"]); 
        $this->setItemAt(6, 3, $efekt);


        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::FEATHER);
        $efekt->setCustomName("§r§9§lJUMP BOOST III");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §9128 emeraldy§8!"]); 
        $this->setItemAt(6, 4, $efekt);

        /*$efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_SWORD);
        $efekt->setCustomName("§r§9§lSTRENGTH I");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §964 emeraldy§8!"]); 
        $this->setItemAt(8, 2, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_SWORD);
        $efekt->setCustomName("§r§9§lSTRENGTH II");
        $efekt->setLore(["§r§8» §7Czas trwania: §93 minuty§8!", "§r§8» §7Koszt: §9128 emeraldy§8!"]); 
        $this->setItemAt(8, 3, $efekt);*/

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_EYE);
        $efekt->setCustomName("§r§9§lNIGHT VISION");
        $efekt->setLore(["§r§8» §7Czas trwania: §95 minut§8!", "§r§8» §7Koszt: §916 emeraldow§8!"]); 
        $this->setItemAt(8, 4, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
        $efekt->setCustomName("§r§9§lEFEKTY DO KOPANIA");
        $efekt->setLore(["§r§9§lPosiada: \n§r§8» §9HASTE II \n§r§8» §9SPEED III", "§r§8» §7Czas trwania: §95 minut§8!", "§r§8» §7Koszt: §9192 emeraldy§8!"]);
        $this->setItemAt(3, 6, $efekt);

        $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::FEATHER);
        $efekt->setCustomName("§r§9§lEFEKTY DO UCIECZKI");
        $efekt->setLore(["§r§9§lPosiada: \n§r§8» §9SPEED I \n§r§8» §9JUMP BOOST III", "§r§8» §7Czas trwania: §95 minut§8!", "§r§8» §7Koszt: §9256 emeraldy§8!"]);
        $this->setItemAt(5, 6, $efekt);

         $efekt = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_SWORD);
        $efekt->setCustomName("§r§9§lEFEKTY DO KLEPY");
        $efekt->setLore(["§r§9§lPosiada: \n§r§8» §9SPEED I \n§r§8» §9BRAK", "§r§8» §7Czas trwania: §94 minuty§8!", "§r§8» §7Koszt: §9256 emeraldy§8!"]);
        $this->setItemAt(7, 6, $efekt);


    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;

        if($item->getId() === \pocketmine\item\ItemIds::DIAMOND_PICKAXE AND $slot == 10) {
            //if($item->getName() === "§r§9§lHASTE I") {
                $count = 32;
                $time = 60 * 3;
                $level = 0;

                if ($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                    $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                    $player->addEffect(new EffectInstance(Effect::getEffect(Effect::HASTE), 20 * ($time), $level));
                    $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));

                    $this->unClickItem($player);

                } else {
                    $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));

                    $this->unClickItem($player);
                    $this->setItems($player);
                //}

            }
        }

        if($item->getId() === \pocketmine\item\ItemIds::DIAMOND_PICKAXE AND $slot == 19) {

            $count = 64;
            $time = 60*3;
            $level = 1;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::HASTE), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() === \pocketmine\item\ItemIds::MAGMA_CREAM AND $slot == 28) {
            $count = 32;
            $time = 60*5;
            $level = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::FIRE_RESISTANCE), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::SUGAR AND $slot == 12) {
            $count = 32;
            $time = 60*3;
            $level = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

         if($item->getId() == \pocketmine\item\ItemIds::SUGAR AND $slot == 21) {
            $count = 64;
            $time = 60*3;
            $level = 1;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

         if($item->getId() == \pocketmine\item\ItemIds::SUGAR AND $slot == 30) {
            $count = 128;
            $time = 60*3;
            $level = 2;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

         if($item->getId() == \pocketmine\item\ItemIds::FEATHER AND $slot == 14) {
            $count = 32;
            $time = 60*3;
            $level = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::FEATHER AND $slot == 23) {
            $count = 64;
            $time = 60*3;
            $level = 1;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::FEATHER AND $slot == 32) {
            $count = 128;
            $time = 60*3;
            $level = 2;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_SWORD AND $slot == 16) {
            $count = 64;
            $time = 60*3;
            $level = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_SWORD AND $slot == 25) {
            $count = 128;
            $time = 60*3;
            $level = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::ENDER_EYE AND $slot == 34) {
            $count = 16;
            $time = 60*5;
            $level = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::NIGHT_VISION), 20*($time), $level));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_PICKAXE AND $slot == 47) {
            $count = 192;
            $time = 60*5;
            $level = 1;
            $level2 = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::HASTE), 20*($time), $level));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*($time), $level2));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::FEATHER AND $slot == 49) {
            $count = 256;
            $time = 60*5;
            $level = 1;
            $level2 = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::JUMP), 20*($time), $level2));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*($time), $level2));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }

        if($item->getId() == \pocketmine\item\ItemIds::DIAMOND_SWORD AND $slot == 51) {
            $count = 256;
            $time = 60*4;
            $level = 1;
            $level2 = 0;

            if($player->getInventory()->contains(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count))) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $count));
               // $player->addEffect(new EffectInstance(Effect::getEffect(Effect::STRENGTH), 20*($time), $level));
                $player->addEffect(new EffectInstance(Effect::getEffect(Effect::SPEED), 20*($time), $level2));
                $player->sendMessage(Main::format("Pomyslnie zakupiono ten efekt!"));
                $this->setItems($player);

                $this->unClickItem($player);

            } else {
                $player->sendMessage(Main::format("Nie mozesz zakupic tego efektu poniewaz posiadasz zbyt malo emeraldow"));
                $this->setItems($player);

                $this->unClickItem($player);

            }
        }
        
        return true;
    }
}