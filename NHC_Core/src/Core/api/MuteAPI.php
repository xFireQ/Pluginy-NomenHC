<?php

namespace Core\api;

use pocketmine\player\Player;

use Core\Main;

class MuteAPI {

    public function setMute(string $nick, string $reason, string $adminNick, ?int $time = null) : void {

        $date = null;

        if($time !== null) {
            $date = date("H:i:s");

            $date = date('d.m.Y H:i:s', strtotime($date) + $time);
        }

        Main::getInstance()->getDb()->query("INSERT INTO mute (nick, reason, date, adminNick) VALUES ('$nick', '$reason', '$date', '$adminNick')");
    }

    public function unmute(string $nick) : void {
        Main::getInstance()->getDb()->query("DELETE FROM mute WHERE nick = '$nick'");
    }

    public function isMuted(string $nick) : bool {
        return !empty(Main::getInstance()->getDb()->query("SELECT * FROM mute WHERE nick = '$nick'")->fetchArray());
    }

    public function getMuteMessage(Player $player) : string {

        $nick = $player->getName();

        $array = Main::getInstance()->getDb()->query("SELECT * FROM mute WHERE nick = '$nick'")->fetchArray(SQLITE3_ASSOC);

        $adminNick = $array['adminNick'];
        $reason = $array['reason'];
        $array['date'] == null ? $date = "NIGDY" : $date = date("d.m.Y | H:i:s", strtotime($array['date']));

        return "§cZostales zmutowany przez: §4$adminNick §cWygasa: §4$date §cPowod: §4$reason";
    }
}