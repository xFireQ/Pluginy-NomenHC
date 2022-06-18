<?php

namespace Core\command\commands\player;

use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\command\{
    Command, CommandSender
};

use Core\Main;

use Core\command\BaseCommand;

class PingCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("ping", "Komenda ping", [], false);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

        if($sender instanceof Player)
            $sender->sendMessage(Main::format("Twoj ping: ".$sender->getPing()));

    }
}