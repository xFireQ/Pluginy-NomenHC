<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\utils\Utils;
use Core\managers\SchowekManager;
use Core\user\UserManager;
use Core\Main;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\level;
use pocketmine\block\Block;
use pocketmine\math\Vector3;
use pocketmine\item\Item;

class SchowekForm extends Form {

    public function __construct(Player $player) {
        $name = $player->getName();
        $user = UserManager::getUser($name)->getDeposit();

        $koxy = $user->getKoxy();
        $refy = $user->getRefy();
        $perly = $user->getPerly();
        $sniezki = 0;
        $rzucaki = 0;
    	 
        $data = [
            "type" => "form",
            "title" => "§r§b§lSCHOWEK",
		    "content" => "",
		     "buttons" => []
	
        ];

        //$data["content"][] = ["type" => "label", "text" => "§7Ogolne ustawienia"];
        
        $data["buttons"][] = ["text" => "§3Koxy §8(§c{$koxy}§8)", "image" => ["type" => "path", "data" => "textures/items/apple_golden"]];
        
        
        $data["buttons"][] = ["text" => "§3Refy §8(§2{$refy}§8)", "image" => ["type" => "path", "data" => "textures/items/apple_golden"]];
        
        $data["buttons"][] = ["text" => "§3Perly §8(§2{$perly}§8)", "image" => ["type" => "path", "data" => "textures/items/ender_pearl"]];
        
        $data["buttons"][] = ["text" => "§3Sniezki §8(§2{$sniezki}§8)", "image" => ["type" => "path", "data" => "textures/items/snowball"]];
        
        $data["buttons"][] = ["text" => "§3Rzucaki §8(§2{$rzucaki}§8)", "image" => ["type" => "path", "data" => "textures/blocks/46-0"]];
        
        $data["buttons"][] = ["text" => "§l§2DOPELNIJ DO LIMITU", "image" => ["type" => "path", "data" => "textures/items/nether_star"]];
       
        
       
        
        
        
        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
    	$formData = json_decode($data);
		
		if($formData === null) return;
		$gracz = $player;
		$nick = $player->getName();
        $user = UserManager::getUser($nick)->getDeposit();

		$countK = $user->getKoxy();
		$countR = $user->getRefy();
		$countP = $user->getPerly;
		
		$countRz = 0;
		
		$countS = 0;
		
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
		
		
		switch($formData) {
		    
			case 0:
			    if($countK > 0) {
			 $user->setKoxy($user->getKoxy() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(466, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 koxa"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz koxow w schowku"));
			    }
			break;
			
			case 1:
			    if($countR > 0) {
                    $user->setRefy($user->getRefy() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(322, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 refa"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz refow w schowku"));
			    }
			break;
			
			case 2:
			    if($countP > 0) {
                    $user->setPerly($user->getPerly() - 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(368, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 perle"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz perel w schowku"));
			    }
			break;
			
			case 3:
			    if($countS > 0) {
			 //SchowekManager::removeSniezki($player, 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(332, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 sniezke"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz sniezek w schowku"));
			    }
			break;
			
			case 4:
			    if($countRz > 0) {
			 //SchowekManager::removeRzucaki($player, 1);
			 $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(46, 0, 1));
			 $player->sendMessage(Main::format("Pomyslnie wyplacono 1 rzucak"));
			    } else {
			        $player->sendMessage(Main::format("Nie posiadasz rzucakow w schowku"));
			    }
			break;
			
			case 5:
			    
			    
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
          
          if ($item->getId() == 46) {
            $iloscRz += $item->getCount();
          }
        }

        $iloscK < 2 ? $iloscK = 2 - $iloscK : $iloscK = 0;

        $iloscR < 8 ? $iloscR = 8 - $iloscR : $iloscR = 0;

        $iloscP < 3 ? $iloscP = 3 - $iloscP : $iloscP = 0;
        
        $iloscS < 16 ? $iloscS = 16 - $iloscS : $iloscS = 0;
        
        $iloscRz < 3 ? $iloscRz = 3 - $iloscRz : $iloscRz = 0;

        $koxy > $iloscK ? $iloscK = $iloscK : $iloscK = $koxy;

        $refy > $iloscR ? $iloscR = $iloscR : $iloscR = $refy;

        $perly > $iloscP ? $iloscP = $iloscP : $iloscP = $perly;
        
        $sniezki > $iloscS ? $iloscS = $iloscS : $iloscS = $sniezki;
        
        $rzucaki > $iloscRz ? $iloscRz = $iloscRz : $iloscRz = $rzucaki;

        $user->setKoxy($user->getKoxy() - $iloscK);
        $user->setRefy($user->getRefy() - $iloscR);
        $user->setPerly($user->getPerly() - $iloscP);

        $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(466, 0, $iloscK));
        $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(322, 0, $iloscR));
        $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(368, 0, $iloscP));
        $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(332, 0, $iloscS));
        $gracz->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(46, 0, $iloscRz));

        $gracz->sendMessage(Main::format("Pomyslie dopelniono do limitu"));
      
			    
			break;
        
    }
    $player->sendForm(new SchowekForm($player));
   }
}