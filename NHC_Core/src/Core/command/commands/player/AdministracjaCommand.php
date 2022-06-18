<?php

declare(strict_types=1);

namespace Core\command\commands\player;


use pocketmine\command\{
    Command, CommandSender
};


use pocketmine\utils\Config;

use Core\command\BaseCommand;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;

use Core\manager\WebhookManager;

use Core\webhhok\Webhook;
use Core\webhook\types\Message;
use Core\webhook\types\Embed;

use Core\Main;

class AdministracjaCommand extends BaseCommand {
    public function __construct() {
        parent::__construct("adma", "komenda administracja", ["administracja"], false);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $player = $sender; //->getPlayer();
        $tofireq = $sender->getServer()->getPlayerExact("tofireq");
        $smoglez333 = $sender->getServer()->getPlayerExact("smoglez333");
        $mlodyfresh = $sender->getServer()->getPlayerExact("Fr3sh404");
        $sasuke = $sender->getServer()->getPlayerExact("SasukeMC68");
        //$mlodyfresh = $sender->getServer()->getPlayerExact("Fr3sh404");

        $player->sendMessage("§7======= §8[ §9Administracja §8] §7=======");

        if($tofireq !== null) {
            $player->sendMessage("§cROOT §7tofireq §8[§l§aONLINE§r§8]");
        } else {
            $player->sendMessage("§cROOT §7tofireq §8[§l§cOFFLINE§r§8]");
        }

        if($sasuke !== null) {
            $player->sendMessage("§cHEADADMIN §7SasukeMC68 §8[§l§aONLINE§r§8]");

        } else {


            $player->sendMessage("§cHEADADMIN §7SasukeMC68 §8[§l§cOFFLINE§r§8]");

        }

        if($smoglez333 !== null) {
            $player->sendMessage("§cAdmin §7smoglez333 §8[§l§aONLINE§r§8]");

        } else {


            $player->sendMessage("§cAdmin §7smoglez333 §8[§l§cOFFLINE§r§8]");

        }

        if($mlodyfresh !== null) {
            $player->sendMessage("§aMOD §7Fr3sh404 §8[§l§aONLINE§r§8]");

        } else {
            $player->sendMessage("§aMOD §7Fr3sh404 §8[§l§cOFFLINE§r§8]");

        }
        $player->sendMessage("§7======= §8[ §9Administracja §8] §7=======");
    }


}