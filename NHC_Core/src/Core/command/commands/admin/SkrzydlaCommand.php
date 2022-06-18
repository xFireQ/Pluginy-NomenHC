<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use Core\command\BaseCommand;
use pocketmine\command\CommandSender;
use Core\util\MessageUtil;
use Core\wings\WingsManager;

class SkrzydlaCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("skrzydla", "komenda wings", ["wings"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            $sender->sendMessage(MessageUtil::format("Poprawne uzycie: /wings &8(%Mdaj&7/%Modbierz&7/%Mlista&7/%Mnick gracza&8)"));
            return;
        }

        switch(strtolower($args[0])) {
            case "daj":
            case "dodaj":
            case "add":
                if(!isset($args[2])) {
                    $sender->sendMessage(MessageUtil::format("Poprawne uzycie: /wings " . $args[0] . " &8(%Mnick&8) &8(%Mskrzydla&8)"));
                    return;
                }

                $wings = WingsManager::getWings($args[2]);

                if($wings === null) {
                    $sender->sendMessage(MessageUtil::format("Te skrzydla nie istnieja!"));
                    return;
                }

                WingsManager::setPlayerWings($args[1], $wings);
                $sender->sendMessage(MessageUtil::format("Nadano graczowi %M" . $args[1] . " %Cskrzydla: %M" . $wings->getName()));

                $player = $sender->getServer()->getPlayerExact($args[1]);

                if($player !== null)
                    WingsManager::setWings($player, $wings);
                break;
            case "odbierz":
            case "usun":
            case "remove":
                if(!isset($args[1])) {
                    $sender->sendMessage(MessageUtil::format("Poprawne uzycie: /wings " . $args[0] . " &8(%Mnick&8)"));
                    return;
                }

                if(!WingsManager::hasPlayerWings($args[1])) {
                    $sender->sendMessage(MessageUtil::format("Ten gracz nie posiada zadnych skrzydelek!"));
                    return;
                }

                WingsManager::removePlayerWings($args[1]);
                $sender->sendMessage(MessageUtil::format("Odebrano graczowi %M" . $args[1] . " %Cskrzydla"));
                $player = $sender->getServer()->getPlayerExact($args[1]);

                if($player !== null)
                    WingsManager::removeWings($player);
                break;
            case "lista":
            case "list":
                $sender->sendMessage(MessageUtil::format("Lista dostepnych skrzydel: %M" . implode("&7, %M", WingsManager::getWingsNames())));
                break;
            default:
                $wings = WingsManager::getPlayerWings($args[0]);

                if($wings === null)
                    $sender->sendMessage(MessageUtil::format("Ten gracz nie posiada zadnych skrzydelek!"));
                else
                    $sender->sendMessage(MessageUtil::format("Skrzydelka gracza %M" . $args[0] . "%C: %M" . $wings->getName()));
        }
    }
}