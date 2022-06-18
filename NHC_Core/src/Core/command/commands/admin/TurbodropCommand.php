<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender, ConsoleCommandSender
};
use Core\command\BaseCommand;
use pocketmine\Server;
use Core\format\Format;
use Core\Main;
use Core\task\MeteoriteTask;
use Core\task\TurbodropTask;
use Core\user\User;
use pocketmine\player\Player;
use pocketmine\world\Position;

class TurbodropCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("turbodrop", "Komenda turbodrop", ["td"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

        if(empty($args)) {
            Format::sendMessage($sender, 1, "Poprawne uzycie &9/turbodrop &8[&9all/nick&8] &8[&9Czas w minutach&8]");
            return;
        }
        if(isset($args[0])) {
            if($args[0] === "all") {
                if(isset($args[1])) {
                    if (!is_numeric($args[1])) {
                        Format::sendMessage($sender, 1, "Podano zly argument");
                        return;
                    }

                    foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                        $nameOnline = $onlinePlayer->getName();
                        if (isset(User::$tdTask[$nameOnline])) {
                            User::$tdTask[$nameOnline]->cancel();
                            unset(User::$tdTask[$nameOnline]);
                        }

                        $time = $args[1] * 60;
                        User::$tdTask[$nameOnline] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new TurbodropTask($onlinePlayer, $time), 20);
                        $onlinePlayer->sendTitle("§r§r§6TurboDrop", "§7Turbodrop zostal §awlaczony!");
                        $onlinePlayer->sendMessage(Main::format("TurboDrop dla serwera zostal wlaczony"));
                        return;
                    }
                }

            }

        }

        if(isset($args[0])) {
            if (isset($args[1])) {
                if (!is_numeric($args[1])) {
                    Format::sendMessage($sender, 1, "Podano zly argument");
                    return;
                }

                $player = Server::getInstance()->getPlayerExact($args[0]);
                $name = $player === null ? $args[1] : $player->getName();

                if ($name == null or $player == null) {
                    Format::sendMessage($sender, 1, "Ten gracz jest offline!");
                    return;
                }

                if (isset(User::$tdTask[$name])) {
                    User::$tdTask[$name]->cancel();
                    unset(User::$tdTask[$name]);

                }

                $time = $args[1] * 60;
                User::$tdTask[$name] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new TurbodropTask($player, $time), 20);
                $sender->sendTitle("§r§r§9TurboDrop", "§7Turbodrop zostal §awlaczony!");

            }
        }
    }
}