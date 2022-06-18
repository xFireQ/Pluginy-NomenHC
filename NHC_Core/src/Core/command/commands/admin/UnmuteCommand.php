<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use Core\user\UserManager;
use Core\util\FormatUtils;
use pocketmine\command\CommandSender;
use Core\command\BaseCommand;

class UnmuteCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("unmute", "Komenda unmute", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        
        if(empty($args)) {
            $sender->sendMessage(FormatUtils::messageFormat("Poprawne uzycie: /unmute §8[§2nick§8]"));
            return;
        }

        $player = $sender->getServer()->getPlayerExact($args[0]);

        $nick = $player == null ? $args[0] : $player->getName();

        $user = UserManager::getUser($nick);

        if($user == null) {
            $sender->sendMessage(FormatUtils::messageFormat("Nie znaleziono uzytkownika!"));
            return;
        }

        if(!$user->isMuted()) {
            $sender->sendMessage(FormatUtils::messageFormat("Ten gracz nie jest zmutowany!"));
            return;
        }

        $user->unmute();

        $sender->sendMessage(FormatUtils::messageFormat("Odmutowano gracza §9{$player->getName()}"));

        if($player)
            $player->sendMessage(FormatUtils::messageFormat("Zostales odmutowany!"));
    }
}
