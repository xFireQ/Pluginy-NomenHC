<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use pocketmine\{
	Server, player\Player
};
use pocketmine\command\{
	Command, CommandSender
};
use Core\command\BaseCommand;
use Core\Main;
use Core\group\GroupManager;
use Core\managers\ChatManager;

class PexCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("pex", "komenda pex", [], false, true);
		//$this->setPermission("xdarkcraft.command.pex");
	}

	public function onCommand(CommandSender $sender, array $args) : void {
		$groupManager = Main::getInstance()->getGroupManager();

		if(empty($args) || isset($args[0]) && $args[0] == "help") {
			if(!$sender->hasPermission("pex.command.general")) {
				$sender->sendMessage(Main::getPermissionMessage());
				return;
			}
			
		 $sender->sendMessage("§7Dostepne Komendy:");
		 $sender->sendMessage("§9/pex reload §8- §7Laduje ponownie plugin");
		 $sender->sendMessage("§9/pex set default group (group) §8- §7ustawia domyslna range");
		 
		 $sender->sendMessage("§9/pex user §8- §7");
		 $sender->sendMessage("§9/pex user (nick) §8- §7pokazuje rangi gracza");
		 $sender->sendMessage("§9/pex user (nick) list §8- §7pokazuje permisje gracza");
		 $sender->sendMessage("§9/pex user (nick) add (permission) {time[s/m/h/d]} §8- §7daje graczowi permisje");
		 $sender->sendMessage("§9/pex user (nick) remove (permission) §8- §7usuwa permisje graczowi");
		 $sender->sendMessage("§9/pex user (nick) group set (group) §8- §7Ustawia graczowi range");
		 $sender->sendMessage("§9/pex user (nick) group add (group) {time[s/m/h/d]} §8- §7Nadaje graczowi range");
		 $sender->sendMessage("§9/pex user (nick) group remove (group) §8- §7usuwa range gracza");
		 
		 $sender->sendMessage("§9/pex group §8- §7Pokazuje liste rang");
		 $sender->sendMessage("§9/pex group (group) list §8- §7Pokazuje liste permisji gracza");
		 
		 $sender->sendMessage("§9/pex group (group) format set (format) §8- §7Ustawia format rangi");
		 $sender->sendMessage("§9/pex group (group) format remove §8- §7Usuwa format rangi");
		 $sender->sendMessage("§9/pex group (group) rank (rank) §8- §7Ustawia rank rangi");
		 $sender->sendMessage("§9/pex group (group) displayname §8- §7ustawienia grupy gracza");
		 $sender->sendMessage("§9/pex group (group) nametag §8- §7nametag");
		 $sender->sendMessage("§9/pex group (group) create {parents} §8- §7tworzy range");
		 $sender->sendMessage("§9/pex group (group) delete §8- §7usuwa range");
		 $sender->sendMessage("§9/pex group add (permission) §8- §7Dodaje permisje do rangi");
		 $sender->sendMessage("§9/pex group (group) remove (permission) §8- §7usuwa permisje z rangi");
		
		 return;
		}

		switch($args[0]) {
			
			
			case "reload":
			 if(!$sender->hasPermission("pex.command.reload")) {
			  $sender->sendMessage(Main::getPermissionMessage());
			 	return;
		 	}
		 	Main::getInstance()->reload();
		 	$sender->sendMessage(Main::format("Plugin zostal zaladowany Pomyslnie"));
			break;
			
			case "set":
		 	if(!$sender->hasPermission("pex.command.set")) {
		 		$sender->sendMessage(Main::getPermissionMessage());
	 			return;
		 	}
		 	
		 	if(!isset($args[1])) {
		 		$sender->sendMessage(Main::getErrorMessage());
		 		return;
		 	}
			 switch($args[1]) {
			 	case "chat":
			 	 if(!isset($args[2])) {
			 	 	$sender->sendMessage(Main::getErrorMessage());
			 	 	return;
			 	 }
			 	 
			 	 switch($args[2]) {
			 	 	case "pw":
			 	 	 if(!isset($args[3]) || (isset($args[3]) && !in_array($args[3], ["true", "false"]))) {
			 	 	 	$sender->sendMessage(Main::format("Uzycie: /pex set chat pw (true/false)"));
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 if($args[3] == "false") {
			 	 	 	ChatManager::setChatPerWorld(false);
			 	 	 	$sender->sendMessage(Main::format("Chat per world has been unsetted"));
			 	 	 } elseif($args[3] == "true") {
			 	 	 	ChatManager::setChatPerWorld();
			 	 	 	$sender->sendMessage(Main::format("Chat per world has been setted"));
			 	 	 }
			 	 	break;
			 	 	default:
			 	 	 $sender->sendMessage(Main::getErrorMessage());
			 	 }
			 	break;
			 	case "default":
			 	 switch($args[2]) {
			 	 	case "group":
			 	 	 if(!isset($args[3])) {
			 	 	 	$sender->sendMessage("Uzycie: /pex set default group (group)");
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 if(!$groupManager->isGroupExists($args[3])) {
			 	 	 	$sender->sendMessage(Main::format("Nie znaleziono grupy!"));
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 $groupManager->setDefaultGroup($groupManager->getGroup($args[3]));
			 	 	 $sender->sendMessage(Main::format("Ustawiono grupe ”§9{$args[3]}§7”"));
			 	 	break;
			 	 	default:
			 	   $sender->sendMessage(Main::getErrorMessage());
			 	 }
			 	break;
			 	default:
			 	 $sender->sendMessage(Main::getErrorMessage());
			 }
			break;
			
			
			case "group":
	 		 if(!$sender->hasPermission("pex.command.groups")) {
		 		$sender->sendMessage(Main::getPermissionMessage());
			 	return;
		 	}
		 	
			 if(!isset($args[1])) {
			  $sender->sendMessage("§7Zarejestrowane GRUPY: ");
			  foreach($groupManager->getAllGroups() as $group) {
			 	
			 	 $parentsFormat = function($group) : string {
			 		 $format = "";
			 		
			 	 	foreach($group->getParents() as $g)
			 		  $format .= $g->getName().", ";
			 		 
			 		 if($format != "")
			 	  	$format = substr($format, 0, strlen($format) - 2);
 
			  	 return $format;
			  	};
			  	
			 	 $sender->sendMessage(" §7{$group->getName()} #{$group->getRank()} §9[{$parentsFormat($group)}]");
			 	}
			 	return;
			 }
			 
			 if(!isset($args[2])) {
			 	$sender->sendMessage(Main::getErrorMessage());
			 	return;
			 }
			 
			 switch($args[2]) {
			 	case "nametag":
			 	 if(!$groupManager->isGroupExists($args[1])) {
		  	 	$sender->sendMessage(Main::format("Grupa nie istnieje!"));
			   	return;
		  	 }
		  	 
		  	 $group = $groupManager->getGroup($args[1]);
		  	 
		  	 if(!isset($args[3])) {
		  	 	$nametag = $group->getNametag();
		  	 	
		  	 	$sender->sendMessage(Main::format($nametag == null ? "Ta grupa nie posiada nametagu!" : "Group §9{$args[1]} §7nametag: §9{$nametag}"));
		  	 	return;
		  	 }
		  	 
		  	 switch($args[3]) {
		  	 	case "set":
		  	 	 if(!isset($args[4])) {
		  	 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] nametag set (nametag format)"));
		  	 	 	return;
		  	 	 }
		  	 	 
		  	 	 $group->setNametag($args[4]);	 
		  	   $sender->sendMessage(Main::format("Grupa §9{$args[1]} §7name tag ustawiony §9{$args[4]}"));
		  	 	break;
		  	 	
		  	 	case "remove":
		  	 	 $group->setNametag();
		  	   $sender->sendMessage(Main::format("Grupa §9{$args[1]} §7nametag usuniety"));
		  	 	break;
		  	 	
		  	 	default:
		  	 	 $sender->sendMessage(Main::getErrorMessage());
		  	 }
			 	break;
			 	
			 	case "displayname":
			 	 if(!$groupManager->isGroupExists($args[1])) {
		  	 	$sender->sendMessage(Main::format("Ta grupa nie istnieje!"));
			   	return;
		  	 }
		  	 
		  	 $group = $groupManager->getGroup($args[1]);
		  	 
		  	 if(!isset($args[3])) {
		  	 	$displayName = $group->getDisplayName();
		  	 	
		  	 	$sender->sendMessage(Main::format($displayName == null ? "Grupa nie posiada nametag!" : "Group §9{$args[1]} §7displayname: §9{$displayName}"));
		  	 	return;
		  	 }
		  	 
		  	 switch($args[3]) {
		  	 	case "set":
		  	 	 if(!isset($args[4])) {
		  	 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] displayname set (displayname)"));
		  	 	 	return;
		  	 	 }
		  	 	 
		  	 	 $group->setDisplayName($args[4]);	 
		  	   $sender->sendMessage(Main::format("Grupa §9{$args[1]} §7displayname ustawiona na §9{$args[4]}"));
		  	 	break;
		  	 	
		  	 	case "remove":
		  	 	 $group->setDisplayName();
		  	   $sender->sendMessage(Main::format("Grupa §9{$args[1]} §7displayname zostala usunieta"));
		  	 	break;
		  	 	
		  	 	default:
		  	 	 $sender->sendMessage(Main::getErrorMessage());
		  	 }
			 	break;
			 	case "list":
			 	 if(!$groupManager->isGroupExists($args[1])) {
		  	 	$sender->sendMessage(Main::format("Grupa nie ostnieje!"));
			   	return;
		  	 }
		  	 
		  	 $group = $groupManager->getGroup($args[1]);
		  	 
			 	 $sender->sendMessage("§7Grupa ”§9{$args[1]}§7” permisje:");
			 	 

    	 foreach($group->getPermissions() as $permission) {
    	 	foreach($group->getParents() as $parentGroup) {
    	 	 if($parentGroup->hasPermission($permission)) {
    	 	 	$sender->sendMessage(" §7{$permission} ({$parentGroup->getName()})");
    	 	 	continue;
    	 	 }
                $sender->sendMessage(" §7{$permission} (own)");
    	 	}
    	 }
			 	break;
			 	
			 	case "players":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			 	  return;
			   }
			   
			 	 $sender->sendMessage("§7Grupa ”§9{$args[1]}§7” gracze:");
    	 foreach($groupManager->getGroup($args[1])->getPlayers() as $nick)
    	  $sender->sendMessage(" §7{$nick}");
			 	break;
			 	
			 	case "format":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			 	  return;
			   }
			   
			   if(!isset($args[3])) {
			   	$sender->sendMessage(Main::getErrorMessage());
			   	return;
			   }
			   
			 	 switch($args[3]) {
			 	 	case "set":
			 	 	 if(!isset($args[4])) {
			 	 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] format set (format)"));
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 $groupManager->getGroup($args[1])->setFormat(str_replace('&', '§', $args[4]));
			 	 	 
			 	 	 $sender->sendMessage(Main::format("Format grupy zaaktualizowany!"));
			 	 	break;
			 	 	
			 	 	case "remove":
			 	 	 $groupManager->getGroup($args[1])->removeFormat();
			 	 	 
			 	 	 $sender->sendMessage(Main::format("Format grp usuniety!"));
			 	 	break;
			 	 	
			 	 	default:
			 	 	 $sender->sendMessage(Main::getErrorMessage());
			 	 }
			 	break;
			 	
			 	case "rank":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			 	  return;
			   }
			   
      if(!isset($args[3])) {
      	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] rank (rank)"));
      	return;
      }
      
      if(!is_numeric($args[3])) {
      	$sender->sendMessage(Main::format("Rank musi byc numeryczny!"));
      	return;
      }
      
      $groupManager->getGroup($args[1])->setRank((int) $args[3]);
      
      $sender->sendMessage(Main::format("{$args[1]} ustawiono range na #{$args[3]}"));
     break;
			 	
			 	case "create":
			 	 $parents = [];
			 	 
			 	 if($groupManager->isGroupExists($args[1])) {
			 	 	$sender->sendMessage(Main::format("Ta grupa juz istnieje!"));
			 	 	return;
			 	 }
			 	 
			 	 if(isset($args[3])) {
			 	 	$arg = str_replace(' ', '', strtolower($args[3]));
			 	 	$parents = explode(',', $arg);
			 	 	
			 	 	foreach($parents as $parentGroup)
			 	 	 if(!$groupManager->isGroupExists($parentGroup))
			 	 	  unset($parents[array_search($parentGroup, $parents)]);
			 	 }
			 	 
			 	 $groupManager->createGroup($args[1], $parents);
			 	 $sender->sendMessage(Main::format("Grupa ”§9{$args[1]}§7” stworzona!"));
			 	break;
			 	
			 	case "delete":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grupa nie istnieje!"));
			 	  return;
			   }
			   
			 	 $groupManager->getGroup($args[1])->delete();
			 	 $sender->sendMessage(Main::format("Grupa ”§9{$args[1]}§7” usunieta!"));
			 	break;
			 	
			 	case "add":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			 	  return;
			   }
			   
			 	 if(!isset($args[3])) {
			 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] add (permission)"));
			 	 	return;
			 	 }
			 	 $perm = strtolower($args[3]);
			 	 
			 	 $groupManager->getGroup($args[1])->addPermission($perm);
			 	 $sender->sendMessage(Main::format("Permisje ”§9{$perm}§7” dodano do ”§9{$args[1]}§7”!"));
			 	break;
			 	
			 	case "remove":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			 	  return;
			   }
			   
			 	 if(!isset($args[3])) {
			 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] remove (permission)"));
			 	 	return;
			 	 }
			 	 $perm = strtolower($args[3]);
			 	 
			 	 $groupManager->getGroup($args[1])->removePermission($perm);
			 	 $sender->sendMessage(Main::format("Permisja ”§9{$perm}§7” usunieta z ”§9{$args[1]}§7”!"));
			 	break;
			 	
			 	case "parents":
			 	 if(!$groupManager->isGroupExists($args[1])) {
			   	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			 	  return;
			   }
			 	 if(!isset($args[3])) {
			 	 	$sender->sendMessage(Main::getErrorMessage());
			 	 	return;
			 	 }
			 	 
			 	 switch($args[3]) {
			 	 	case "set":
			 	 	 if(!isset($args[4])) {
			 	 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] parents set (parents)"));
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 if(!$groupManager->isGroupExists($args[4])) {
			     	$sender->sendMessage(Main::format("Parent grl nie istnieje!"));
			     	return;
			     }
			     
			     if($groupManager->getGroup($args[4])->hasParent($groupManager->getGroup($args[1]))) {
			     	$sender->sendMessage(Main::format("Grupa nie posiada {$args[1]}’s parent!"));
			     	return;
			     }
			 	 	 
			 	 	 $groupManager->getGroup($args[1])->removeParents();
			 	 	 $groupManager->getGroup($args[1])->addParent($groupManager->getGroup($args[4]));
			 	 	 
			 	 	 $sender->sendMessage(Main::format("Parent ”§9{$args[4]}§7” ustawiono na ”§9{$args[1]}§7”!"));
			 	 	break;
			 	 	
			 	 	case "add":
			 	 	 if(!isset($args[4])) {
			 	 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] parents add (parents)"));
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 if(!$groupManager->isGroupExists($args[4])) {
			     	$sender->sendMessage(Main::format("Grp nie istnieje!"));
			     	return;
			     }
			     
			     if($groupManager->getGroup($args[4])->hasParent($groupManager->getGroup($args[1]))) {
			     	$sender->sendMessage(Main::format("Grupa ”§9{$args[4]}§7” nie moze byc  §9{$args[1]}§7’s parent"));
			     	return;
			     }

			 	 	 $groupManager->getGroup($args[1])->addParent($groupManager->getGroup($args[4]));
			 	 	 
			 	 	 $sender->sendMessage(Main::format("Parent ”§9{$args[4]}§7” ustawiono na ”§9{$args[1]}§7”!"));
			 	 	break;
			 	 	
			 	 	case "remove":
			 	 	 if(!isset($args[4])) {
			 	 	 	$sender->sendMessage(Main::format("Uzycie: /pex group $args[1] parents remove (parents)"));
			 	 	 	return;
			 	 	 }
			 	 	 
			 	 	 if(!$groupManager->isGroupExists($args[4])) {
			     	$sender->sendMessage(Main::format("Parent nie istnieje!"));
			     	return;
			     } 
			     
			 	 	 $groupManager->getGroup($args[1])->removeParent($groupManager->getGroup($args[4]));
			 	 	 
			 	 	 $sender->sendMessage(Main::format("Parent ”§9{$args[4]}§7” usunieto z ”§9{$args[1]}§7”!"));
			 	 	break;
			 	 	
			 	 	default:
			 	 	 $sender->sendMessage(Main::getErrorMessage());
			 	 }
			 	break;
			 	default:
			 	 $sender->sendMessage(Main::getErrorMessage());
			 }
			break;
			
   case "user":
   if(!$sender->hasPermission("pex.command.users")) {
   	$sender->sendMessage(Main::getPermissionMessage());
		 	return;
		 }
		 
   if(!isset($args[1])) {
   	$sender->sendMessage("§7Gracze:");
   	foreach(Main::getInstance()->getProvider()->getAllUsers() as $nick)
   	 $sender->sendMessage(" §7{$nick}");
   	
   	return;
   }
   
   if(!$groupManager->userExists($args[1])) {
   	$sender->sendMessage(Main::format("Nie ma takiego gracza!"));
   	return;
   }
   
    if(!isset($args[2])) {
     $sender->sendMessage("§7{$args[1]} grupy:");
     foreach($groupManager->getAllGroups() as $group) {
     	if(!$groupManager->getPlayer($args[1])->hasGroup($group))
      $sender->sendMessage("§9Grupa §7{$group->getName()}§9: §7Nie posiada");
      else {
      	$expiryTime = $groupManager->getPlayer($args[1])->getGroupExpiry($group);
      	$expiryFormat = GroupManager::expiryFormat($expiryTime);
      	
       $sender->sendMessage("§9Grupa §7{$group->getName()}§9: §7".($expiryTime == null ? "na zawsze" : "§9{$expiryFormat['days']}§7d §9{$expiryFormat['hours']}§7h §9{$expiryFormat['minutes']}§7m §9{$expiryFormat['seconds']}§7s"));
      }
     }
     return;
    }
    
    switch($args[2]) {
    	case "world":
    	 if(!isset($args[4])) {
    	 	$sender->sendMessage(Main::getErrorMessage());
    	 	return;
    	 }
    	 
    	 $levelName = $args[3];
    	 
    	 switch($args[4]) {
    	 	case "add":
    	   if(!isset($args[5])) {
    	   	$sender->sendMessage(Main::format("Usage: /pex user $args[1] world $args[5] add (permission) {time[s/m/h/d]}"));
    	   	return;
    	   }
    	   $time = null;
        
        if(isset($args[6])) {
  	      if(strpos($args[6], "d"))
		        $time = intval(explode("d", $args[6])[0]) * 86400;
            
         if(strpos($args[6], "h"))
	 	       $time = intval(explode("h", $args[6])[0]) * 3600;

	   	    if(strpos($args[6], "m"))
		        $time = intval(explode("h", $args[6])[0]) * 60;

	 	      if(strpos($args[6], "s"))
	 	       $time = intval(explode("s", $args[6])[0]);
	 	      $playerManager = $groupManager->getPlayer($args[1])->addPermission($args[5], $time);
        } else
         $playerManager = $groupManager->getPlayer($args[1])->addPermission($args[5]);
    	 
    	   $sender->sendMessage(Main::format("Permission ”§9{$args[5]}§7” added to world §9{$levelName}§7".($time == null ? "" : " for §9{$args[6]}")));
    	  break;
    	
      	case "group":
        if(!isset($args[6])) {
         $sender->sendMessage(Main::getErrorMessage());
         return;
        }
      
        if(!$groupManager->isGroupExists($args[6])) {
         $sender->sendMessage(Main::format("Ta grp nie istnieje!"));
         return;
        }
      
        switch($args[5]) {
        	case "add":  
          $playerManager = $groupManager->getPlayer($args[1]);
        
          $player = $playerManager->getPlayer();
          $nick = $player instanceof Player ? $player->getName() : $args[1];
        
          $time = null;
        
          if(isset($args[7])) {
  	        if(strpos($args[7], "d"))
		          $time = intval(explode("d", $args[7])[0]) * 86400;
          
          	if(strpos($args[7], "h"))
	 	         $time = intval(explode("h", $args[7])[0]) * 3600;

	         	if(strpos($args[7], "m"))
		          $time = intval(explode("h", $args[7])[0]) * 60;

	 	        if(strpos($args[7], "s"))
	 	         $time = intval(explode("s", $args[7])[0]);
	 	        $playerManager->addGroup($groupManager->getGroup($args[6]), $time, $levelName);
          } else
           $playerManager->addGroup($groupManager->getGroup($args[6]), null, $levelName);
        
          $sender->sendMessage(Main::format("Uzytkownik §9{$nick} §7dodano na swiecie §9{$levelName} §7”§9{$args[6]}§7”".($time == null ? "" : " na §9{$args[7]}")));
         break;
   
         case "set":
          $playerManager = $groupManager->getPlayer($args[1]);
    
          $player = $playerManager->getPlayer();
          $nick = $player instanceof Player ? $player->getName() : $args[1];
    
          $time = null;
        
          if(isset($args[7])) {
  	        if(strpos($args[7], "d"))
		          $time = intval(explode("d", $args[7])[0]) * 86400;
          
           if(strpos($args[7], "h"))
	 	         $time = intval(explode("h", $args[7])[0]) * 3600;

	         	if(strpos($args[7], "m"))
		          $time = intval(explode("h", $args[7])[0]) * 60;

	 	        if(strpos($args[7], "s"))
	 	         $time = intval(explode("s", $args[7])[0]);
	 	        $playerManager->setGroup($groupManager->getGroup($args[6]), $time, $levelName);
          } else
           $playerManager->setGroup($groupManager->getGroup($args[6]), null, $levelName);
        
          $sender->sendMessage(Main::format("{$nick}’ Grupa ustawiona ”§9{$args[4]}§7” na swiecie §9{$levelName}§7".($time == null ? "" : " na §9{$args[5]}")));
           
           break;
           
           case "remove":      
            $playerManager = $groupManager->getPlayer($args[1]);
            
            $player = $playerManager->getPlayer();
            $nick = $player instanceof Player ? $player->getName() : $args[1];
            
            $playerManager->removeGroup($groupManager->getGroup($args[6]), true, $levelName);
        
            $sender->sendMessage(Main::format("Uzytkownik §9{$nick} §7usunieto grupe z ”§9{$args[4]}§7” na swiecie: §9{$levelName}"));
           break;
           default:
			 	       $sender->sendMessage(Main::getErrorMessage());
          }
         break;
   
         default:
			       $sender->sendMessage(Main::getErrorMessage());
      }
    	break;
    	
    	case "list":
    	 $sender->sendMessage("§7{$args[1]} permisje:");
    	 foreach($groupManager->getPlayer($args[1])->getPermissions() as $permission)
    	  $sender->sendMessage(" §7{$permission}");
    	break;
    	
    	case "delete":
    	 $groupManager->getPlayer($args[1])->delete();
    	 $sender->sendMessage("Uzytkownik §9{$args[1]} §7usuniety!");
    	break;
    	
    	case "add":
    	 if(!isset($args[3])) {
    	 	$sender->sendMessage(Main::format("Uzycie: /pex user $args[1] add (permission) {time[s/m/h/d]}"));
    	 	return;
    	 }
    	 $time = null;
        
      if(isset($args[4])) {
  	    if(strpos($args[4], "d"))
		      $time = intval(explode("d", $args[4])[0]) * 86400;
          
       if(strpos($args[4], "h"))
	 	     $time = intval(explode("h", $args[4])[0]) * 3600;

	   	  if(strpos($args[4], "m"))
		      $time = intval(explode("h", $args[4])[0]) * 60;

	 	    if(strpos($args[4], "s"))
	 	     $time = intval(explode("s", $args[4])[0]);
	 	    $playerManager = $groupManager->getPlayer($args[1])->addPermission($args[3], $time);
      } else
       $playerManager = $groupManager->getPlayer($args[1])->addPermission($args[3]);
    	 
    	 $sender->sendMessage(Main::format("Permisje ”§9{$args[3]}§7” dodane!".($time == null ? "" : " dla §9{$args[4]}")));
    	break;
    	
    	case "remove":
    	 if(!isset($args[3])) {
    	 	$sender->sendMessage(Main::format("Uzycie: /pex user $args[1] remove (permission)"));
    	 	return;
    	 }
    	 
    	 $playerManager = $groupManager->getPlayer($args[1])->removePermission($args[3]);
    	 $sender->sendMessage(Main::format("Permisje ”§9{$args[3]}§7” usunieto!"));
    	break;
    	
    	case "group":
      if(!isset($args[4])) {
       $sender->sendMessage(Main::getErrorMessage());
       return;
      }
      
      if(!$groupManager->isGroupExists($args[4])) {
       $sender->sendMessage(Main::format("Ta grp nie istnieje!"));
       return;
      }
      
      switch($args[3]) {
      	case "add":  
        $playerManager = $groupManager->getPlayer($args[1]);
        
        $player = $playerManager->getPlayer();
        $nick = $player instanceof Player ? $player->getName() : $args[1];
        
        $time = null;
        
        if(isset($args[5])) {
  	      if(strpos($args[5], "d"))
		        $time = intval(explode("d", $args[5])[0]) * 86400;
          
        	if(strpos($args[5], "h"))
	 	       $time = intval(explode("h", $args[5])[0]) * 3600;

	       	if(strpos($args[5], "m"))
		        $time = intval(explode("h", $args[5])[0]) * 60;

	 	      if(strpos($args[5], "s"))
	 	       $time = intval(explode("s", $args[5])[0]);
	 	      $playerManager->addGroup($groupManager->getGroup($args[4]), $time);
        } else
         $playerManager->addGroup($groupManager->getGroup($args[4]));
        
        $sender->sendMessage(Main::format("Uzytkownik §9{$nick} §7dodano grp ”§9{$args[4]}§7”".($time == null ? "" : " Dla §9{$args[5]}")));
   break;
   
       case "remove":      
        $playerManager = $groupManager->getPlayer($args[1]);
        
        $player = $playerManager->getPlayer();
        $nick = $player instanceof Player ? $player->getName() : $args[1];
        
        $playerManager->removeGroup($groupManager->getGroup($args[4]));
        
        $sender->sendMessage(Main::format("Uzytkownik §9{$nick} §7usuniety z grp ”§9{$args[4]}§7”"));
   break;
   
   case "set":
    $playerManager = $groupManager->getPlayer($args[1]);
    
    $player = $playerManager->getPlayer();
    $nick = $player instanceof Player ? $player->getName() : $args[1];
    
    $time = null;
        
    if(isset($args[5])) {
  	  if(strpos($args[5], "d"))
		    $time = intval(explode("d", $args[5])[0]) * 86400;
          
     if(strpos($args[5], "h"))
	 	   $time = intval(explode("h", $args[5])[0]) * 3600;

	   	if(strpos($args[5], "m"))
		    $time = intval(explode("h", $args[5])[0]) * 60;

	 	  if(strpos($args[5], "s"))
	 	   $time = intval(explode("s", $args[5])[0]);
	 	  $playerManager->setGroup($groupManager->getGroup($args[4]), $time);
    } else
     $playerManager->setGroup($groupManager->getGroup($args[4]));
        
    $sender->sendMessage(Main::format("{$nick}’ ustawiono grupe: ”§9{$args[4]}§7”".($time == null ? "" : " dla §9{$args[5]}")));
     
     break;
     default:
			 	 $sender->sendMessage(Main::getErrorMessage());
    }
   break;
   
   default:
			 $sender->sendMessage(Main::getErrorMessage());
  }
 break;
 default:
		$sender->sendMessage(Main::getErrorMessage());
		}
	}
}