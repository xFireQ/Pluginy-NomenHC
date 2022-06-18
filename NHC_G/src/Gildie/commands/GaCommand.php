<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender, utils\CommandException};
use Gildie\Main;

class GaCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("ga", "Komenda ga", true);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;

        if(empty($args)) {
            $sender->sendMessage(" \n§8          §9§lNomenHC.PL\n\n");

            $sender->sendMessage("§8»§r §9/ga tp §8(§9gildia§8) - §7Teleportuje do wybranej gildii");
            $sender->sendMessage("\n");
            return;
        }

        $guildManager = Main::getInstance()->getGuildManager();

        switch($args[0]) {
            case "tp":
                if(!isset($args[1])) {
                    $sender->sendMessage("§7Poprawne uzycie: /ga tp §8(§9gildia§8)");
                    return;
                }

                if(!$guildManager->isGuildExists($args[1])) {
                    $sender->sendMessage("§8§l>§r §7Ta gildia nie istnieje!");
                    return;
                }

                $guild = $guildManager->getGuildByTag($args[1]);

                $tpPos = $guild->getBase();

                if(isset($args[2]) && is_numeric($args[2]))
                    $tpPos->y = (int)$args[2];

                //$sender->teleport($tpPos);
                $sender->sendMessage("§7Przeteleportowano do gildii §9{$args[1]}");
            break;

            default:
                $sender->sendMessage("§7Nieznany argument!");
        }
    }
}