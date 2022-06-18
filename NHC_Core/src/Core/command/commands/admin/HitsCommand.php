<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender, ConsoleCommandSender
};

use Core\Main;

use pocketmine\player\Player;

use Core\command\BaseCommand;

class HitsCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("hity", "Komenda hity", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $config = Main::getInstance()->getConfig();
        if(empty($args)) {

            return;
        }

        if(isset($args[0])) {
            $hits = (float) $args[0];
            $config->set("hits", "$hits");
            $config->save();
        }
    }
}