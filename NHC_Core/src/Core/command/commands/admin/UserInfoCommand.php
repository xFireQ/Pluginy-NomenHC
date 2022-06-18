<?php

namespace Core\command\commands\admin;

use Core\format\Format;
use Core\Main;
use pocketmine\command\CommandSender;
use Core\command\BaseCommand;
use pocketmine\utils\Config;

class UserInfoCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("user", "Komenda user", ["hack"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            Format::sendMessage($sender, 1, "Poprawne uzycie /user nick");
        }

        if(isset($args[0])) {
            if(file_exists(Main::getInstance()->getDataFolder() . "players/" . $args[0].".yml")) {
                $config2 = new Config(Main::getInstance()->getDataFolder() . "players/" . $args[0].".yml");
                $ip = $config2->get("IP");
                $xuid = $config2->get("XUID");
                $uuid = $config2->get("UUID");
                $name = $config2->get("Nazwa");
                $port = $config2->get("Port");
                $ping = $config2->get("Ping");
                $device = $config2->get("Urzadzenie");

                Format::sendMessage($sender, 1, "Gracz &9".$name);
                Format::sendMessage($sender, 1, "Ip &9".$ip);
                Format::sendMessage($sender, 1, "Urzadzenie &9".$device);
                Format::sendMessage($sender, 1, "ping &9".$ping);
                Format::sendMessage($sender, 1, "port &9".$port);
                Format::sendMessage($sender, 1, "xuid &9".$xuid);
                Format::sendMessage($sender, 1, "uuid &9".$uuid);

            } else {
                Format::sendMessage($sender, 1, "Ten gracz nie istnieje!");
            }
        }
    }
}