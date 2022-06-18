<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender
};

use Core\Main;
use Core\task\MeteoriteTask;
use Core\utils\ConfigUtil;
use pocketmine\player\Player;
use Core\command\BaseCommand;

class MeteoriteCommand extends BaseCommand {

    public function __construct() {
      parent::__construct("meteorite", "komenda meteorite", ["meteoryt"], false, true);
 }
 
 public function onCommand(CommandSender $sender, array $args) : void {

        if($sender instanceof Player) {

        if(empty($args)) {
            $sender->sendMessage(Main::format("Poprawne uzycie to: §9/meteoryt §8(§9czas w minutach§8)"));
        }

        if(isset($args[0])) {

            $x = $sender->getPosition()->getPosition()->getFloorX();
            $y = $sender->getPosition()->getFloorY();
            $z = $sender->getPosition()->getFloorZ();

            $time = intval(explode("h", $args[0])[0]) * 60;

            if($time == null or $time == 0) {
                $sender->sendMessage(Main::format("Poprawne uzycie to: §9/meteoryt §8(§9czas w minutach§8)"));
                return;
            }
            $sender->sendMessage("§aEvent wystartowal!");
            Main::getInstance()->getScheduler()->scheduleRepeatingTask(new MeteoriteTask($time, $x, $y, $z), 20);

        }
        } else {
            $sender->sendMessage("Aby uzyc tej komendy musisz byc w grze!");
        }
    }
}