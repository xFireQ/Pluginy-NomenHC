<?php

declare(strict_types=1);

namespace Core\wings;

use pocketmine\entity\Skin;
use pocketmine\player\Player;
use Core\Main;
use Core\managers\SkinManager;
use Core\util\SkinUtil;

class WingsManager {

    private static $db;
    private static $wings = [];
    private static $wingsNames = [];

    public static function init(Main $main) : void {
        self::$db = new \SQLite3($main->getDataFolder() . "Database.db");
        self::$db->query("CREATE TABLE IF NOT EXISTS wings (player TEXT, wings TEXT)");

        self::load($main);
    }

    public static function load(Main $main) : void {
        $wingsNames = [];

        $path = $main->getDataFolder() . "wings" . DIRECTORY_SEPARATOR;

        foreach(scandir($path) as $fileName) {
            if(in_array($fileName, [".", ".."]))
                continue;

            if(is_dir($path . $fileName))
                $wingsNames[] = $fileName;
        }

        self::$wingsNames = $wingsNames;

        foreach($wingsNames as $wingName)
            self::$wings[$wingName] = new Wings($wingName, $path);
    }

    public static function getWings(string $name) : ?Wings {
        return self::$wings[$name] ?? null;
    }

    public static function getWingsNames() : array {
        return self::$wingsNames;
    }

    public static function setWings(Player $player, Wings $wings) : void {
        $skin = $player->getSkin();
        $name = $player->getName();

        $skinImage = SkinManager::getPlayerSkinImage($name);

        $linkedImage = self::linkPlayerAndWingsSkin($skinImage, $wings->getImage());

        $player->setSkin(new Skin($skin->getSkinId(), SkinUtil::skinImageToBytes($linkedImage), "", $wings->getGeometryName(), $wings->getGeometryData()));
        $player->sendSkin();
    }

    public static function removeWings(Player $player) : void {
        $player->setSkin(SkinManager::getPlayerSkin($player));
        $player->sendSkin();
    }

    public static function linkPlayerAndWingsSkin($playerSkin, $wingsSkin) {
        imagecopymerge($wingsSkin, $playerSkin, 0, 0, 0, 0, imagesx($playerSkin), imagesy($playerSkin), 100);

        return $wingsSkin;
    }

    public static function getPlayerWings(string $name) : ?Wings {
        $name = strtolower($name);
        $array = self::$db->query("SELECT * FROM wings WHERE player = '" . $name . "'")->fetchArray(SQLITE3_ASSOC);

        if(empty($array))
            return null;

        $wings = self::getWings($array['wings']);

        if($wings === null) {
            self::removePlayerWings($name);
            return null;
        }

        return $wings;
    }

    public static function hasPlayerWings(string $name) : bool {
        return self::getPlayerWings($name) !== null;
    }

    public static function setPlayerWings(string $name, Wings $wings) : void {
        $name = strtolower($name);
        if(self::hasPlayerWings($name))
            self::removePlayerWings($name);

        self::$db->query("INSERT INTO wings (player, wings) VALUES ('" . $name . "', '" . $wings->getName() . "')");
    }

    public static function removePlayerWings(string $name) : void {
        $name = strtolower($name);
        self::$db->query("DELETE FROM wings WHERE player = '" . $name . "'");
    }
}