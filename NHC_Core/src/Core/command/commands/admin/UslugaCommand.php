<?php

declare(strict_types=1);

namespace Core\command\commands\admin;


use pocketmine\command\{
    Command, CommandSender,
    ConsoleCommandSender
};

use Core\managers\WebhookManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\utils\Config;

use Core\command\BaseCommand;

use Core\utils\Utils;
use Core\settings\SettingsManager;

use pocketmine\player\Player;
use pocketmine\Server;

use Core\managers\IsManager;

use Core\Main;

class UslugaCommand extends BaseCommand {
    public function __construct() {
        parent::__construct("usluga", "komenda usluga", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        //$player = $sender;
        $p = $sender;

        if(empty($args[0]) or empty($args[1])) {
            $sender->sendMessage(Main::format("Poprawne uzycie: §9/usluga §8[§9nick§8] [§9vip§8/§9svip§8/§9sponsor§8/§9yt§8/§9yt+§8/§9pc8§8/§9pc16§8/§9pc32§8/§9pc64§8/§9pc128§8/§9pc256§8/§9pc512§8]"));
        }



        if(isset($args[1])) {
            $nick = "{$args[0]}";

            if($args[1] === "vip") {
                IsManager::addUsluga($args[0], "vip", 0);
            }

            if($args[1] === "svip") {
                IsManager::addUsluga($args[0], "svip", 0);
            }

            if($args[1] === "sponsor") {
                IsManager::addUsluga($args[0], "sponsor", 0);

            }

            if($args[1] === "pc8") {
                IsManager::addUsluga($args[0], "pc8", 0);

            }

            if($args[1] === "pc16") {
                IsManager::addUsluga($args[0], "pc16", 0);

            }

            if($args[1] === "pc32") {
                IsManager::addUsluga($args[0], "pc32", 0);

            }

            if($args[1] === "pc64") {
                IsManager::addUsluga($args[0], "pc64", 0);

            }

            if($args[1] === "pc128") {
                IsManager::addUsluga($args[0], "pc128", 0);

            }

            if($args[1] === "pc256") {
                IsManager::addUsluga($args[0], "pc256", 0);

            }

            if($args[1] === "pc512") {
                IsManager::addUsluga($args[0], "pc512", 0);

            }

            if($args[1] === "yt") {
                Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $args[0] group set yt 30d");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$args[0] §7zdobyl range §9YT NA EDYCJE");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                //$p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eWsparcie", "§r§6Gracz $args[0] zdobyl range YT");
            }

            if($args[1] === "yt+") {
                Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $args[0] group set yt+ 30d");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$args[0] §7zdobyl range §9YT+ NA EDYCJE");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                //$p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eWsparcie", "§r§6Gracz $args[0] zdobyl range YT+");
            }


        }
    }


}