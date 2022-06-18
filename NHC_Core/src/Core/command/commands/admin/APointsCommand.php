<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender
};
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;
use Core\command\BaseCommand;
use Core\utils\Utils;
use pocketmine\player\Player;
use pocketmine\Server;
use Core\managers\BackupManager;
use Core\user\UserManager;
use Core\user\SaveInventory;
use Core\Main;

class APointsCommand extends BaseCommand {
    use SaveInventory;

    public function __construct() {
        parent::__construct("adminpoints", "komenda adminpoints", ["ap", "adminpoints"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            $sender->sendMessage("§7Uzycie §l§9/adminpoints §r§8(§9§lnick§r§8) §r§8(§9§lset§r§8/§r§l§9sprawdz§r§8/§r§9§ldodaj§r§8/§9§lusun§r§8) §r§8(§9§lilosc§r§8) ");
            return;
        }

        if(isset($args[0])) {
            if(isset($args[1])) {
                $player = Server::getInstance()->getPlayer($args[0]);
                $name = $player == null ? $args[0] : $player->getName();
                if($player == null or $name == null) {
                    $sender->sendMessage("§7Ten gracz jest offline!");
                    return;
                }

                $user = UserManager::getUser($name)->getPoints();

                if($args[1] == "sprawdz") {
                    UserManager::saveUsers();

                    foreach(UserManager::getUsers() as $users) {
                        $users->saveDeposit();
                        $users->savePoints();
                        $users->saveDrop();
                    }
                    UserManager::init();

                    $points = $user->getPoints();
                    $sender->sendMessage(Main::format("Punkty §l§9" . $points . " §r§7gracza§9§l " . $name));
                    return;
                }

                if(isset($args[2])) {
                    if($args[1] == "set") {
                        $points = (int) $args[2];
                        $user->setPoints($points);
                        $sender->sendMessage(Main::format("Pomyslnie ustawiono §l§9" . $points . " §r§7punktow graczowi§9§l " . $name));
                    }

                    if($args[1] == "dodaj") {
                        $points = $user->getPoints() + (int) $args[2];
                        $user->setPoints($points);
                        $sender->sendMessage(Main::format("Pomyslnie dodano §l§9" . $args[2] . " §r§7punktow graczowi§9§l " . $name));
                    }

                    if($args[1] == "usun") {
                        $points = $user->getPoints() - (int) $args[2];
                        $user->setPoints($points);
                        $sender->sendMessage(Main::format("Pomyslnie usunieto §l§9" . $args[2] . " §r§7punktow graczowi§9§l " . $name));
                    }

                } else {
                    $sender->sendMessage("§7Uzycie §l§9/adminpoints §r§8(§9§lnick§r§8) §r§8(§9§lset§r§8/§9§ladd§r§8/§9§lusun§r§8) §r§8(§9§lilosc§r§8) ");
                }
            } else {
                $sender->sendMessage("§7Uzycie §l§9/adminpoints §r§8(§9§lnick§r§8) §r§8(§9§lset§r§8/§9§ladd§r§8/§9§lusun§r§8) §r§8(§9§lilosc§r§8) ");
            }
        }
    }
}