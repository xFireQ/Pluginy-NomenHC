<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\manager\BlacklistManager;
use Core\user\UserManager;
use Core\util\FormatUtils;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerLoginEvent;
use pocketmine\event\player\PlayerPreLoginEvent;
use Core\Main;

class PlayerPreJoinListener implements Listener {

    public function onLogin(PlayerLoginEvent $event): void {
        $player = $event->getPlayer();
        $nick = $player->getName();
        $smallNick = strtolower($nick);
        $PlayersNick = Main::$whitelist->get("NickPlayers");
        $kickmsg = Main::$whitelist->get("KickMessage");

        if(Main::$whitelist->get("Status") == true) {
            if(in_array($smallNick, $PlayersNick) or $player->isOp()) {
                //var_dump("ZALICZONY DO DODANYCH NA WL");
            } else {

                $player->close("", " ".str_replace("&", "§", "&r&f".$kickmsg));
                //var_dump("NIE ZALICZONY DO DODANYCH NA WL");
            }
        }
    }
}
