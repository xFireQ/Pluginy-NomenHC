<?php

declare(strict_types=1);

namespace Core\util;

class FormatUtils {

    public static function messageFormat(string $string) : string {
        return "§8[§9Nomen§fHC§r§8] §7$string";
    }

    public static function messageFormatLines(array $w) : string {
        return "§8» §7".implode("\n§8» §7", $w)."\n ";
    }

    public static function cooldownFormat(string $date) : string {
        $time = strtotime($date) - time();

        $hours = floor($time / 3600);
        $minutes = floor(($time / 60) % 60);
        $seconds = $time % 60;

        if($hours < 10)
            $hours = "0{$hours}";

        if($minutes < 10)
            $minutes = "0{$minutes}";

        if($seconds < 10)
            $seconds = "0{$seconds}";

        return "§9{$hours}§8:§9{$minutes}§8:§9{$seconds}";
    }

    public static function banFormat(string $reason, string $adminName, ?string $date) : string {
        if($date == null)
            $date = "NIGDY";

        return "§8[§9§lNomen§fHC§r§8] §7Zostales zbanowany na serwerze"."\n".
        "§7Przez administratora: §9".$adminName."\n".
        "§7Z powodem: §9".$reason."\n".
        "§7Wygasa za: §9".$date."\n".
        "§7Kup unbana na §9www.NomenHC.PL";
    }

    public static function muteFormat(string $reason, string $adminName, ?string $date) : string {
        if($date == null)
            $date = "NIGDY";

        return "Zostales zmutowany przez §c$adminName wygasa za: §c$date, powod mute'a: §c$reason";
    }
}
