<?php

declare(strict_types=1);

namespace Core\managers;

use pocketmine\entity\Skin;
use pocketmine\player\Player;
use Core\Main;

class SkinManager {

    private static $playersSkins = [];
    private static $playersSkinsPath;
    private static $defaultGeometryName;
    private static $defaultGeometryData;

    public static function init(Main $main) : void {
        $main->saveResource("defaultSkin.png");
        $main->saveResource("defaultGeometry.json");
        self::$playersSkinsPath = Main::getInstance()->getDataFolder() . "playersSkins" . DIRECTORY_SEPARATOR;
        self::$defaultGeometryName = "geometry.defaultGeometry";
        self::$defaultGeometryData = file_get_contents(Main::getInstance()->getDataFolder() . "defaultGeometry.json");
    }

    public static function setPlayerSkinImage(string $name, $resource) : void {
        imagepng($resource, self::$playersSkinsPath . $name . ".png");
    }

    public static function setPlayerDefaultSkin(string $name) : void {
        copy(Main::getInstance()->getDataFolder() . "defaultSkin.png", self::$playersSkinsPath . $name . ".png");
    }

    public static function getDefaultGeometryName() : string {
        return self::$defaultGeometryName;
    }

    public static function getDefaultGeometryData() : string {
        return self::$defaultGeometryData;
    }

    public static function getPlayerSkinImage(string $name) {
        if(!is_file(self::$playersSkinsPath . $name . ".png"))
            self::setPlayerDefaultSkin($name);

        $resource = imagecreatefrompng(self::$playersSkinsPath . $name . ".png");
        imagecolortransparent($resource, imagecolorallocatealpha($resource, 0, 0, 0, 127));

        return $resource;
    }

    public static function setPlayerSkin(Player $player, Skin $skin) : void {
        self::$playersSkins[$player->getName()] = $skin;
    }

    public static function removePlayerSkin(Player $player) : void {
        unset(self::$playersSkins[$player->getName()]);
    }

    public static function getPlayerSkin(Player $player) : ?Skin {
        return self::$playersSkins[$player->getName()] ?? null;
    }
}