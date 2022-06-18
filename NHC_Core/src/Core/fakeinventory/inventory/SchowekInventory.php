<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use Core\user\UserManager;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\drop\DropManager;
use Core\managers\SchowekManager;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\level;
use Core\Main;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\math\Vector3;

class SchowekInventory extends FakeInventory {

    

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9SCHOWEK");

        $this->setItems($player);
    }

    public function setItems(Player $player) : void {

        $name = $player->getName();
        $user = UserManager::getUser($name)->getDeposit();

        $koxyy = $user->getKoxy();
        $refyy = $user->getRefy();
        $perlyy = $user->getPerly();
        $sniezkiy = $user->getSnow();
        $rzucakiy = $user->getRzucak();

        $koxy = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1);
        $koxy->setCustomName("§r§9Koxy §9{$koxyy} \n§r§3Kliknij wyplacic!");
        $refy = \pocketmine\item\ItemFactory::getInstance()->get(322, 0, 1);
        $refy->setCustomName("§r§9Refy §9{$refyy} \n§r§3Kliknij wyplacic!");
        
        $perly = \pocketmine\item\ItemFactory::getInstance()->get(368, 0, 1);
        $perly->setCustomName("§r§9Perly §9{$perlyy} \n§r§3Kliknij wyplacic!");
        
        $snow = \pocketmine\item\ItemFactory::getInstance()->get(332, 0, 1);
        $snow->setCustomName("§r§9Sniezki §9{$sniezkiy} \n§r§3Kliknij wyplacic!");
        
        $tnt = \pocketmine\item\ItemFactory::getInstance()->get(52, 0, 1);
        $tnt->setCustomName("§r§9Rzucaki §9{$rzucakiy} \n§r§3Kliknij wyplacic!");
        
        $dop = \pocketmine\item\ItemFactory::getInstance()->get(399, 0, 1);
        $dop->setCustomName("§r§9§lDopelnij do limitu \n§r§3Kliknij aby dopelnic do limitu!");

        $this->setItemAt(3, 2, $koxy);
        $this->setItemAt(4, 2, $refy);
        $this->setItemAt(5, 2, $perly);
        $this->setItemAt(6, 2, $snow);
        $this->setItemAt(7, 2, $tnt);
        $this->setItemAt(5, 3, $dop);

        
    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $item = $sourceItem;

        $gracz = $player;
        $nick = $player->getName();
        $user = UserManager::getUser($nick)->getDeposit();

        $countK = $user->getKoxy();
        $countR = $user->getRefy();
        $countP = $user->getPerly();
        $countS = $user->getSnow();
        $countRz = $user->getRzucak();

        $koxy = $countK;
        $refy = $countR;
        $perly = $countP;
        $snizeki = $countS;
        $rzucaki = $countRz;
        $iloscK = 0;
        $iloscR = 0;
        $iloscP = 0;
        $iloscS = 0;
        $iloscRz = 0;
        
        if($item->getId() == "466") {
            
            if($countK > 0) {
                $user->setKoxy($user->getKoxy() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 koxa"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz koxow w schowku"));
			    }
			    
            $this->closeFor($player);
        }
        
        if($item->getId() == "322") {
            
            if($countR > 0) {
                $user->setRefy($user->getRefy() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(322, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 refa"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz refow w schowku"));
			    }
            $this->closeFor($player);

        }
        
        if($item->getId() == "368") {
            
            if($countP > 0) {
			 //SchowekManager::removePerly($player, 1);
                $user->setPerly($user->getPerly() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(368, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 perle"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz perel w schowku"));
			    }

            $this->closeFor($player);
        }
        
        if($item->getId() == "332") {
            
            if($countS > 0) {
			 //SchowekManager::removeSnow($player, 1);
                $user->setSnow($user->getSnow() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(332, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 sniezke"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz sniezek w schowku"));
			    }

            $this->closeFor($player);
        }
        
        if($item->getId() == 52) {
            
            if($countRz > 0) {
                $user->setRzucak($user->getRzucak() - 1);
                $rzucakk = \pocketmine\item\ItemFactory::getInstance()->get(52, 0, 1);
                $rzucakk->setCustomName("§r§l§cRzucak");
                $rzucakk->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
			 $player->getInventory()->addItem($rzucakk);
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 rzucak"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz rzucakow w schowku"));
			    }

            $this->closeFor($player);
        }
        
        if($item->getId() == "399") {
            
            foreach ($gracz->getInventory()->getContents() as $item) {
          if ($item->getId() == 466) {
            $iloscK += $item->getCount();
          }
          if ($item->getId() == 322) {
            $iloscR += $item->getCount();
          }
          if ($item->getId() == 368) {
            $iloscP += $item->getCount();
          }

                if ($item->getId() == 332) {
                    $iloscS += $item->getCount();
                }

                if ($item->getId() == 52) {
                    $iloscRz += $item->getCount();
                }
        }
        
        

        $iloscK < 1 ? $iloscK = 1 - $iloscK : $iloscK = 0;

        $iloscR < 6 ? $iloscR = 6 - $iloscR : $iloscR = 0;

        $iloscP < 3 ? $iloscP = 3 - $iloscP : $iloscP = 0;

            $iloscRz < 3 ? $iloscRz = 3 - $iloscRz : $iloscRz = 0;

            $iloscS < 8 ? $iloscS = 8 - $iloscS : $iloscS = 0;

            $snizeki > $iloscS ? $iloscS = $iloscS : $iloscS = $snizeki;

            $rzucaki > $iloscRz ? $iloscRz = $iloscRz : $iloscRz = $rzucaki;

        $koxy > $iloscK ? $iloscK = $iloscK : $iloscK = $koxy;

        $refy > $iloscR ? $iloscR = $iloscR : $iloscR = $refy;

        $perly > $iloscP ? $iloscP = $iloscP : $iloscP = $perly;

            $user->setKoxy($user->getKoxy() - $iloscK);
            $user->setRefy($user->getRefy() - $iloscR);
            $user->setPerly($user->getPerly() - $iloscP);
            $user->setSnow($user->getSnow() - $iloscS);
            $user->setRzucak($user->getRzucak() - $iloscRz);


            $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(466, 0, $iloscK));
            $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(322, 0, $iloscR));
            $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(368, 0, $iloscP));
            $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(332, 0, $iloscS));
            $rzucakk = \pocketmine\item\ItemFactory::getInstance()->get(52, 0, $iloscRz);
            $rzucakk->setCustomName("§r§l§cRzucak");
            $rzucakk->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
            $gracz->getInventory()->addItem($rzucakk);


            $gracz->sendMessage(Main::format("Pomyslie dopelniono do limitu"));

            $this->closeFor($player);

        }
        return true;
    }
}