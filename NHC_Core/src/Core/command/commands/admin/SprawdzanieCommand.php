<?php

namespace Core\command\commands\admin;

use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\math\Vector3;

use Core\Main;

use Core\command\BaseCommand;

class SprawdzanieCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("sprawdzanie", "Komenda sprawdzanie", [], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {

		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}

		if(!isset($args[0])) {
			$sender->sendMessage("§7Poprawne uzycie: \n§7/sprawdzanie sprawdz §8(§9nick§8) \n§7/sprawdzanie zbanuj §8(§9nick§8) \n§7/sprawdzanie czysty §8(§9nick§8) \n§7/sprawdzanie ustaw");
			return;
		}

		switch($args[0]) {

			case "sprawdz":

			 if(!isset($args[1])) {
			 	$sender->sendMessage(Main::format("Poprawne uzycie: /sprawdzanie sprawdz §8(§9nick§8)"));
			 	return;
			 }

			 $player = $sender->getServer()->getPlayerExact($args[1]);

			 if($player == null) {
			 	$sender->sendMessage(Main::format("Ten gracz jest §9offline"));
			 	return;
			 }

			 $nick = $player->getName();

			 if($nick == $sender->getName()) {
			 	$sender->sendMessage(Main::format("Nie mozesz sprawdzic samego siebie!"));
			 	return;
			 }

			 if(isset(Main::$spr[$nick])) {
			 	$sender->sendMessage(Main::format("Ten gracz jest juz sprawdzany!"));
			 	return;
			 }

			 Main::$spr[$nick] = [$player->asVector3(), $sender->getName()];

			 $cfg = Main::getInstance()->getConfig()->get("sprawdzanie");

			 if(!$cfg) {
			     $sender->sendMessage(Main::format("Musisz ustawic pozycje sprawdzania!"));
			     return;
             }

			 $pos = new Vector3($cfg['x'], $cfg['y'], $cfg['z']);

			 //$sender->teleport($pos);
			 //$player->teleport($pos);

			 $sender->getServer()->broadcastMessage(Main::format("Gracz §9$nick §7zostal wezwany do sprawdzania przez administratora §9{$sender->getName()}§7!"));

			 $sender->sendMessage(Main::format("Pomyslnie wezwano do sprawdzania gracza §9$nick"));
			 
			 $player->sendMessage("§7Zostales wezwany do sprawdzania! \n§7Nick administratora: §9{$sender->getName()}§7!");

			break;

			case "zbanuj":

			 if(!isset($args[1])) {
			 	$sender->sendMessage(Main::format("Poprawne uzycie: /sprawdzanie zbanuj §8(§9nick§8)"));
			 	return;
			 }

			 $player = $sender->getServer()->getPlayerExact($args[1]);

			 if($player == null) {
			 	$sender->sendMessage(Main::format("Ten gracz jest §9offline"));
			 	return;
			 }

			 $nick = $player->getName();

			 if(!isset(Main::$spr[$nick])) {
			 	$sender->sendMessage(Main::format("Ten gracz nie jest sprawdzany!"));
			 	return;
			 }

			 //$api = Main::getInstance()->getBanAPI();

			 //$api->setBan($nick, "Cheaty", Main::$spr[$nick][1]);

			 //$player->teleport($player->getWorld()->getSafeSpawn());

			 unset(Main::$spr[$nick]);

			// $player->kick($api->getBanMessage($player), false);

			 //$sender->teleport($sender->getWorld()->getSafeSpawn());

			 $sender->getServer()->broadcastMessage(Main::format("Gracz §9$nick §7zostal zbanowany za §9cheaty§7!"));

			break;

			case "czysty":

			 if(!isset($args[1])) {
			 	$sender->sendMessage(Main::format("Poprawne uzycie: /sprawdzanie czysty §8(§9nick§8)"));
			 	return;
			 }

			 $player = $sender->getServer()->getPlayerExact($args[1]);

			 if($player == null) {
			 	$sender->sendMessage(Main::format("Ten gracz jest §9offline"));
			 	return;
			 }

			 $nick = $player->getName();

			 if(!isset(Main::$spr[$nick])) {
			 	$sender->sendMessage(Main::format("Ten gracz nie jest sprawdzany!"));
			 	return;
			 }

			 //$player->teleport(Main::$spr[$nick][0]);
			 //$sender->teleport($player->getWorld()->getSafeSpawn());

			 unset(Main::$spr[$nick]);

			 $sender->getServer()->broadcastMessage(Main::format("Gracz §9$nick §7okazal sie byc czysty!"));

			break;

			case "ustaw":
			 $pos = $sender->asVector3();

			 $x = $pos->getX();
			 $y = $pos->getY();
			 $z = $pos->getZ();

			 $cfg = Main::getInstance()->getConfig();

			 $cfg->set("sprawdzanie", [
			  "x" => $x,
			  "y" => $y,
			  "z" => $z
			 ]);
			 $cfg->save();

			 $sender->sendMessage(Main::format("Pomyslnie ustawiono pozycje sprawdzarki!"));
			break;

			default:
			 $sender->sendMessage(Main::format("Poprawne uzycie: /sprawdzanie czysty §8(§9nick§8)"));
		}
	}
}
