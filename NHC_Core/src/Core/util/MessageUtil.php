<?php

declare(strict_types=1);

namespace Core\util;

class MessageUtil {

    private const PREFIX = "&8[%MNomen&fHC&8]&r ";
    private const COLOR = "&7";
    private const COLOR_MARK = "&9";

    public static function format(string $message, bool $prefix = true) : string {
        $message = "&8» &7" . $message;

        if($prefix)
            $message = self::PREFIX . $message;

        return self::fixColors($message);
    }

    public static function fixColors($message) : string {
        $message = str_replace("%C", self::COLOR, $message);
        $message = str_replace("%M", self::COLOR_MARK, $message);

        return str_replace("&", "§", $message);
    }
}