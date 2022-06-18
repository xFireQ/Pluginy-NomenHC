<?php

namespace Gildie\form;

use Gildie\guild\GuildManager;
use pocketmine\player\Player;
use Gildie\Main;

class PermissionsForm extends Form {

    private $nick;

	public function __construct(string $nick) {
	    $this->nick = $nick;

		$data = [
		 "type" => "form",
		 "title" => "§7Permisje gracza §2$nick",
		 "content" => "",
		 "buttons" => []
		];

		$guildManager = Main::getInstance()->getGuildManager();

		$data["buttons"][] = ["text" => "Stawianie blokow\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_PLACE) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/blocks/brick"]];
		
		
		$data["buttons"][] = ["text" => "Niszczenie blokow\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_BREAK) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/items/diamond_pickaxe"]];
		
		
		$data["buttons"][] = ["text" => "Stawianie TNT\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_TNT_PLACE) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/blocks/tnt_side"]];
		
		
		$data["buttons"][] = ["text" => "Stawianie i niszczenie skrzyn\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_PLACE_BREAK) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/blocks/chest_front"]];
		$data["buttons"][] = ["text" => "Otwieranie skrzyn\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_OPEN) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/blocks/chest_front"]];
  
  
        $data["buttons"][] = ["text" => "Stawianie i niszcz. beaconow\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_BEACON_PLACE_BREAK) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/blocks/beacon"]];
        
    
        $data["buttons"][] = ["text" => "Tpaccept\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_TPACCEPT) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/items/ender_pearl"]];
        
        
        $data["buttons"][] = ["text" => "Wlaczanie/wylaczanie PVP\n".($guildManager->hasPermission($nick, GuildManager::PERMISSION_PVP) ? "§l§2WLACZONE" : "§l§cWYLACZONE"), "image" => ["type" => "path", "data" => "textures/items/diamond_sword"]];
        
        
        $data["buttons"][] = ["text" => "Wlacz wszystkie"];
        
        $data["buttons"][] = ["text" => "Wylacz wszystkie"];
        
        $data["buttons"][] = ["text" => "Ustaw domyslne permisje"];

        $this->data = $data;
	}
	
	public function handleResponse(Player $player, $data) : void {
		
		$formData = json_decode($data);
		
		if($formData === null) return;

		$guildManager = Main::getInstance()->getGuildManager();

		$player_switch = $player->getServer()->getPlayerExact($this->nick);
		$nick = $this->nick;

		switch($formData) {

            case "0":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_BLOCKS_PLACE);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_PLACE)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do stawiania blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§7Nadano ci permisje do stawiania blokow");
                } else {
                    $player->sendMessage("§7Odebrano graczu §2{$nick} §7permisje do stawiania blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§7Odebrano ci permisje do niszczenia blokow");
                }
            break;

            case "1":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_BLOCKS_BREAK);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_BLOCKS_BREAK)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do niszczenia blokow");

                    if($player_switch != null)
                       $player_switch->sendMessage("§7Nadano ci permisje do niszczenia blokow");
                } else {
                    $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do niszczenia blokow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§7Odebrano ci permisje do niszczenia blokow");
                }
            break;

            case "2":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_TNT_PLACE);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_TNT_PLACE)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do stawiania TNT");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Nadano ci permisje do stawiania TNT");
                } else {
                    $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do stawiania TNT");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Odebrano ci permisje do stawiania TNT");
                }
            break;
            
            case "3":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_CHEST_PLACE_BREAK);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_PLACE_BREAK)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do stawiania skrzynek");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Nadano ci permisje do stawiania skrzynek");
                } else {
                    $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do stawiania skrzynek");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Odebrano ci permisje do stawiania skrzynek");
                }
            break;

            case "4":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_CHEST_OPEN);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_CHEST_OPEN)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do otwierania skrzynek");

                    if($player_switch != null)
                       $player_switch->sendMessage("§r §7Nadano ci permisje do otwierania skrzynek");
                } else {
                   $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do otwierania skrzynek");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Odebrano ci permisje do otwierania skrzynek");
                }
            break;


            case "5":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_BEACON_PLACE_BREAK);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_BEACON_PLACE_BREAK)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do stawiania i niszczenia beaconow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Nadano ci permisje do stawiania i niszczenia beaconow");
                } else {
                    $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do stawiania i niszczenia beaconow");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Odebrano ci permisje do stawiania i niszczenia beaconow");
                }
            break;

            case "6":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_TPACCEPT);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_TPACCEPT)) {
                   $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do uzywania §2/tpaccept §7na terenie gildii");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Nadano ci permisje do uzywania §2/tpaccept §7na terenie gildii");
                } else {
                    $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do uzywania §2/tpaccept §7na terenie gildii");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Odebrano ci permisje do uzywania §2/tpaccept §7na terenie gildii");
                }
            break;

            case "7":
                $guildManager->switchPermission($nick, GuildManager::PERMISSION_PVP);

                if($guildManager->hasPermission($nick, GuildManager::PERMISSION_PVP)) {
                    $player->sendMessage("§r §7Nadano graczu §2{$nick} §7permisje do wlaczania i wylaczania PVP");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Nadano ci permisje do wlaczania i wylaczania PVP");
                } else {
                    $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7permisje do wlaczania i wylaczania PVP");

                    if($player_switch != null)
                        $player_switch->sendMessage("§r §7Odebrano ci permisje do wlaczania i wylaczania PVP");
                }
            break;

            case "8":
                $guildManager->setAllPermissions($nick);

                $player->sendMessage("§r §7Nadano graczu §2{$nick} §7wszystkie permisje");

                if($player_switch != null)
                    $player_switch->sendMessage("§r §7Nadano ci wszystkie permisje");
            break;

            case "9":
                $guildManager->removeAllPermissions($nick);

                $player->sendMessage("§r §7Odebrano graczu §2{$nick} §7wszystkie permisje");

                if($player_switch != null)
                    $player_switch->sendMessage("§r §7Odebrano ci wszystkie permisje");
            break;

            case "10":
                $guildManager->setDefaultPermissions($nick);

                $player->sendMessage("§r §7Nadano graczu §2{$nick} §7domyslne permisje");

                if($player_switch != null)
                    $player_switch->sendMessage("§r §7Nadano ci domyslne permisje");
            break;
        }

		$player->sendForm(new PermissionsForm($this->nick));
	}
}