<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender, ConsoleCommandSender
};

use Core\Main;

use pocketmine\player\Player;
use pocketmine\entity\Human;
use Core\command\BaseCommand;

class XpCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("xp", "Komenda xp", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $sender->setXpLevel(999);
    }
}