<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use pocketmine\command\{
    CommandSender
};
use Core\command\BaseCommand;
use Core\Main;
use Core\user\UserManager;
use Core\utils\Utils;

class AntyCheatCommand extends BaseCommand {
    public function __construct() {
        parent::__construct("antycheat", "komenda antycheat", ["ac"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

        if(isset(UserManager::$ac[$sender->getName()])) {
            unset(UserManager::$ac[$sender->getName()]);
            $sender->sendMessage(Main::format("Powiadomienia o antycheacie zostaly wylaczone!"));
        } else {
            UserManager::$ac[$sender->getName()] = true;
            $sender->sendMessage(Main::format("Powiadomienia o antycheacie zostaly wlaczone!"));

        }

    }
}