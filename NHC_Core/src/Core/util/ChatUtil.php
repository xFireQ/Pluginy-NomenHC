<?php

declare(strict_types=1);

namespace Core\util;

class ChatUtil {

    private const PREFIX = "§r§8[§9Nomen§fHC§8] »";
    private const COLOR = "&7";
    private const COLOR_MARK = "&9";

    public static function format(string $message, bool $prefix = true) : string {
        $message = "&8» %C" . $message;

        if($prefix)
            $message = self::PREFIX . " &r" . $message;

        return self::fixColors($message);
    }

    public static function fixColors(string $message) : string {
        $message = str_replace("%C", self::COLOR, $message);
        $message = str_replace("%M", self::COLOR_MARK, $message);

        return str_replace("&", "§", $message);
    }
}