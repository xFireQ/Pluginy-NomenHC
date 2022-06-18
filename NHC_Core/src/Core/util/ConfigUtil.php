<?php

declare(strict_types=1);

namespace Core\util;

use Core\Main;

final class ConfigUtil {

    private function __construct() {}

    public static function format(string $message) : string {
        $config = Main::getInstance()->getPluginConfig();

        $message = str_replace("%C", $config->getNested("messages.color"), $message);
        $message = str_replace("%M", $config->getNested("messages.color-mark"), $message);

        return ChatUtil::fixColors($message);
    }

    /**
     * @return array|string
     */
    public static function getMessage(string $key, bool $format = true) {
        $config = Main::getInstance()->getPluginConfig();
        $message = $config->getNested($key);

        if(is_array($message)) {
            $lines = [];

            foreach($message as $line) {
                $lines[] = self::format($line);
            }

            return $lines;
        }

        if($message === null) {
            return "";
        }

        return $format ? self::format(str_replace("{MESSAGE}", $message, $config->getNested("messages.format"))) : self::format($message);
    }
}