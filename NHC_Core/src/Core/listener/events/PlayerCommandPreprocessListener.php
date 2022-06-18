<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\command\BaseCommand;
use Core\util\FormatUtils;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerCommandPreprocessEvent;

use Core\Main;
use pocketmine\math\Vector3;
use pocketmine\Server;

class PlayerCommandPreprocessListener implements Listener {
    
    public function CooldownKomendy(PlayerCommandPreprocessEvent $e)
    {
        if (!($e->getMessage()[0] == "/")) return;

        $player = $e->getPlayer();
        $nick = $player->getName();

        if ($player->hasPermission("NomenHC.command.cd")) return;

        isset(Main::$lastCmd[$nick]) ? $time = Main::$lastCmd[$nick] : $time = 0;

        if (time() - $time < 3) {
            $e->cancel(true);

            $player->sendMessage(Main::format("§7Nastepna komende mozesz uzyc za §9" . (3 - (time() - $time)) . " §7sekund!"));
        } else
            Main::$lastCmd[$nick] = time();
    }

    

    public function unknownCommandMessage(PlayerCommandPreprocessEvent $e) : void {
        if($e->getMessage()[0] == '/') {
            $player = $e->getPlayer();
            $cmd = substr(explode(' ', $e->getMessage())[0], 1);

            $commandMap = $player->getServer()->getCommandMap();

            if($commandMap->getCommand($cmd) === null) {
                $e->cancel(true);
                $player->sendMessage(FormatUtils::messageFormat("Ta komenda nie istnieje, uzyj komendy: §9/pomoc"));
            }
        }
    }
}