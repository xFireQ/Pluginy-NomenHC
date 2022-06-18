<?php

namespace Core\command\commands\admin;

use pocketmine\Server;

use pocketmine\command\{
    Command, CommandSender
};

use Core\Main;

use Core\command\BaseCommand;

//use pocketmine\Server;

class DeviceCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("device", "Komenda device", ["os", "urzadzenie"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            $sender->sendMessage("Poprawne uzycie /device nick");
            return;
        }

        if(isset($args)) {
            $player = Server::getInstance()->getPlayer($args[0]);
            $name = $player == null ? $args[0] : $player->getName();
            $device = "BRAK";

            if (Main::getDevice($name) == 7) {
                $device = "Windows 10";
            } elseif (Main::getDevice($name) == 1) {
                $device = "Android";
            } elseif (Main::getDevice($name) == 2) {
                $device = "iOS";
            } else {
                $device = "KONSOLA";
            }

            $sender->sendMessage("Urzadzenie: ".$device);
        }
    }
}
