<?php

namespace Core\warps;

use pocketmine\world\Position;
use Core\Main;

class WarpsManager {
    public static function init(): void {
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS 'warps' (warp TEXT, x DOUBLE, y DOUBLE, z DOUBLE)");
    }

    public static function addWarp(string $warp, int $x, int $y, int $z) : void {
        Main::getDb()->query("INSERT INTO 'warps' (warp, x, y, z) VALUES ('$warp', '$x', '$y', '$z')");
    }

    public static function removeWarp(string $warp) : void {
        Main::getDb()->query("DELETE FROM 'warps' WHERE warp = '$warp'");
    }

    public static function getWarpPos(string $warp, string $pos) {
        $res = Main::getDb()->query("SELECT * FROM 'warps' WHERE warp = '$warp'")->fetchArray(SQLITE3_ASSOC);
        return $res[$pos];

    }

    public static function getWarps() : array {
        $warps = [];

        $result = Main::getDb()->query("SELECT * FROM 'warps'");

        while($array = $result->fetchArray(SQLITE3_ASSOC))
            $warps[] = $array['warp'];

        return $warps;
    }


}