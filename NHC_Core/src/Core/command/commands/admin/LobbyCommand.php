<?php

namespace Core\command\commands\admin;

use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;
use Core\api\LobbyAPI;
use Core\command\BaseCommand;

class LobbyCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("lobby", "Komenda lobby", [], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {
		

		if(empty($args)) {
			$sender->sendMessage(Main::format("Poprawne uzycie: \n/lobby §8(§eon §7| §eoff§8) \n/lobby settime §8(§eD§7:§eM§7:§eY§8) (§eH§7:§eM§8)\n/lobby add §8(§enick§8)\n/lobby remove §8(§enick8)\n/lobby list"));
			return;
		}
		
		switch($args[0]) {
			case "add":
			 if(!isset($args[1])) {
			 	$sender->sendMessage(Main::format("Poprawne uzycie: /lobby add (§enick§8)"));
			 	return;
			 }
			 LobbyAPI::addPlayer($args[1]);
			 
			 $sender->sendMessage(Main::format("Dodano do lobby gracza §e{$args[1]}"));
			break;
			
			case "remove":
			 if(!isset($args[1])) {
			 	$sender->sendMessage(Main::format("Poprawne uzycie: /lobby remove (§enick§8)"));
			 	return;
			 }
			 LobbyAPI::removePlayer($args[1]);
			 
			 $sender->sendMessage(Main::format("Usunieto z lobby gracza §e{$args[1]}"));
			break;
			
			case "list":
			 $sender->sendMessage(Main::format("Lista graczy: §e".implode("§8, §e", LobbyAPI::getLobbyPlayers())));
			break;
			
			case "on":
			 LobbyAPI::setLobby(true);
			 $sender->sendMessage(Main::format("Pomyslnie wlaczono lobby"));
			break;
			
			case "off":
			 LobbyAPI::setLobby(false);
			 $sender->sendMessage(Main::format("Pomyslnie wylaczono lobby"));
			break;
			
			case "settime":
			 if(!isset($args[2])) {
			 	$sender->sendMessage(Main::format("Poprawne uzycie: /lobby settime §8(§eD§7.§eM§7.§eY§8) (§eH§7:§eM§8)"));
			 	return;
			 }
			 
			 $hm = explode(':', $args[2]);
			 
			 if(!is_numeric($hm[0]) || !is_numeric($hm[1]) || $hm[0] > 24 || $hm[1] > 59) {
			 	$sender->sendMessage(Main::format("Nieprawidlowy format godziny!"));
			 	return;
			 }
			 
			 $date = $args[1] . " " . $args[2];
			 
			 if(time() > strtotime($date)) {
			 	$sender->sendMessage(Main::format("Nieprawidlowa data!"));
			 	return;
			 }
			 
			 LobbyAPI::setLobbyDate($date);
			 $sender->sendMessage(Main::format("Pomyslnie ustawiono date wylaczenia lobby na §e$date"));
			break;
			
			default:
                $sender->sendMessage(Main::format("Poprawne uzycie: \n/lobby §8(§eon §7| §eoff§8) \n/lobby settime §8(§eD§7:§eM§7:§eY§8) (§eH§7:§eM§8)\n/lobby add §8(§enick§8)\n/lobby remove §8(§enick8)\n/lobby list"));
        }
	}
}