<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender, utils\CommandException};
use Gildie\Main;

class GCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("g", "Komenda g");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;

    	if(empty($args) || !isset($args[0]) || (isset($args[0]) && !in_array($args[0], ["top", "topka"]))) {
        $sender->sendMessage("§8========== [ §l§9POMOC GILDI §r§8] ==========");
        
        $sender->sendMessage("§9§l/zaloz [tag] [nazwa] §r§8- §7Tworzy gildie");

        $sender->sendMessage("§9§l/opusc§r §8- §7Opuszcza gildie");

        $sender->sendMessage("§9§l/usun §r§8- §7Usuwa gildie");

        $sender->sendMessage("§9§l/ustawbaze§r §8- §7Ustawia miejsce teleportacji do bazy");

        $sender->sendMessage("§l§9/rozwiaz [tag]§r §8- §7Usuwa sojusz gildyjny");

        $sender->sendMessage("§l§9/baza §r§8- §7Teleportuje do bazy gildii");

        $sender->sendMessage("§l§9/dolacz [tag] §r§8- §7Przyjmuje zaproszenie do gildii");

        $sender->sendMessage("§l§9/zapros [gracz]§r §8- §7Zaprasza gracza do gildii");

        $sender->sendMessage("§l§9/lider [gracz]§r §8- §7Oddaje zalozyciela gildii");

        $sender->sendMessage("§l§9/zastepca [gracz] §r§8- §7Nadaje zastepce gildii");

        $sender->sendMessage("§l§9/wyrzuc [gracz] §r§8- §7Wyrzuca gracza z gildii");

        $sender->sendMessage("§l§9/info [tag]§r §8- §7Informacje o danej gildii");


        //$sender->sendMessage("§8§l»§r §9/permisje §8- §7Permisje gildii");

        $sender->sendMessage("§l§9/itemy §r§8- §7Lista przedmiotow potrzebnych na gildie");

        //$sender->sendMessage("§8»§r §9/przedluz §8- §7Przedluza waznosc gildii");

        $sender->sendMessage("§l§9/sojusz [tag] §r§8- §7Sojusz gildyjny");

		$sender->sendMessage("§l§9/walka§r §8- §7Zaprasza innych graczy na walke");

       // $sender->sendMessage("§8»§r §9/powieksz §8- §7Powieksza teren gildii");
        
        //$sender->sendMessage("{$tag}");
        $sender->sendMessage("§8========== [ §l§9POMOC GILDI §r§8] ==========");
        return;
       }
       
       if($args[0] == "top" || $args[0] == "topka") {
       	$guildManager = Main::getInstance()->getGuildManager();
        $top = $guildManager->getGuildsTop();
        
       $sender->sendMessage("§8========== [ §l§9TOP GILDIE §r§8] ==========");
        for($i = 1; $i <= 10; $i++) {
        	if(isset($top[$i]))
     	    $sender->sendMessage("§l§9{$i}§r§8. §7{$top[$i]->getTag()}: §9{$top[$i]->getPoints()}");
     	   else
          $sender->sendMessage("§l§9{$i}§r§8.§7 §7BRAK§r");
        }
        $sender->sendMessage("§8========== [ §l§9TOP GILDIE §r§8] ==========");
    }
    }
}