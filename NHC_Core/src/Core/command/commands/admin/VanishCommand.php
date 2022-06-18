<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
	Command, CommandSender, ConsoleCommandSender
};
use Core\format\Format;
use Core\Main;
use Core\task\VanishTask;
use Core\user\User;
use Core\user\UserManager;
use pocketmine\player\Player;
use Core\command\BaseCommand;

class VanishCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("vanish", "Komenda vanish", ["v"], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            Format::sendMessage($sender, 1, "Poprawne uzycie to:");
            Format::sendMessage($sender, 1, "&9/vanish on &8- &7wlacza vanisha");
            Format::sendMessage($sender, 1, "&9/vanish off &8- &7wylacza vanisha");
            Format::sendMessage($sender, 1, "&9/vanish sprawdz &8- &7sprawdza czy vanish jest wlaczony");
            return;
        }

        if(isset($args[0])) {
            if($args[0] == "on") {
                UserManager::getUser($sender->getName())->setVanish(true);
                User::$vanishTask[$sender->getName()] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new VanishTask(2, $sender), 20);
                Format::sendMessage($sender, 2, "Vanish zostal wlaczony!");
                $sender->hidePlayer($sender);
            }

            if($args[0] == "off") {
                UserManager::getUser($sender->getName())->setVanish(false);
                if(isset(User::$vanishTask[$sender->getName()]))
                    User::$vanishTask[$sender->getName()]->cancel();
                Format::sendMessage($sender, 2, "Vanish zostal wylaczony!");
                $sender->showPlayer($sender);
            }

            if($args[0] == "sprawdz") {
                Format::sendMessage($sender, 2, "Aktualnie vanish jest&9 ".UserManager::getUser($sender->getName())->getVanish()."&7!");
            }
        }
    }
}