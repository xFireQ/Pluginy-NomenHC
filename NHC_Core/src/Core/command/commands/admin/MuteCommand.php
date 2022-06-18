<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use Core\format\Format;
use Core\Main;
use Core\user\UserManager;
use Core\util\FormatUtils;
use pocketmine\command\CommandSender;
use Core\command\BaseCommand;

class MuteCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("mute", "Komenda mute", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

        if(empty($args) || !isset($args[1])) {
            Format::sendMessage($sender, 0, "POPRAWNE UZYCIE");
            Format::sendMessage($sender, 1, "/mute §8[§9NICK§8] §8[§9czas§8]§8[§9h§8/§9m§8/§9s§7]");

            return;
        }

        $api = Main::getInstance()->getMuteAPI();

        $player = $sender->getServer()->getPlayerExact($args[0]);

        $nick = $player == null ? $args[0] : $player->getName();

        if($api->isMuted($nick)) {
            $sender->sendMessage(Main::format("Ten gracz zostal juz zmutowany!"));
            return;
        }
        if($args[1] == "zzzz")
            $time = null;
        else {
            if(!strpos($args[1], "d") && !strpos($args[1], "h") && !strpos($args[1], "m") && !strpos($args[1], "s")){
                $sender->sendMessage(Main::format("Nieprawidlowy format czasu!"));
                return;
            }

            $time = 0;

            if(strpos($args[1], "d"))
                $time = intval(explode("d", $args[1])[0]) * 86400;

            if(strpos($args[1], "h"))
                $time = intval(explode("h", $args[1])[0]) * 3600;

            if(strpos($args[1], "m"))
                $time = intval(explode("h", $args[1])[0]) * 60;

            if(strpos($args[1], "s"))
                $time = intval(explode("s", $args[1])[0]);
        }

        $reason = "";

        for($i = 2; $i <= count($args) - 1; $i++)
            $reason .= $args[$i] . " ";

        if($reason == "") $reason = "BRAK";

        $api->setMute($nick, $reason, $sender->getName(), $time);

        $sender->sendMessage(Main::format("Zmutowano gracza §9$nick §7na czas §9$args[1] §7z powodem: §9$reason"));
        if($player !== null)
            $player->sendMessage(Main::format("Zostales zmutowany przez: §9{$sender->getName()} \nCzas mute: §9$args[1] \nPowod mute: §9$reason"));
    }
}
