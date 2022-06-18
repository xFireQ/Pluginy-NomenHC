<?php

namespace Core\user;

use Core\Main;
use pocketmine\player\Player;

class UserManager {

    /** @var User[] */
    private static array $users = [];
    public static $blazeRod;
    public static $ac = [];
    public static $waterTask = [];

    public static function init() : void {
        Main::getInstance()->getDb()->query("CREATE TABLE IF NOT EXISTS 'users' (nick TEXT, xuid TEXT)");
    }

    public static function deleteDataUser(string $nick) : void{
        unset(self::$users[$nick]);
    }

    public static function createUser(Player $user) : void {
        self::$users[$user->getName()] = new User($user->getName(), $user->getXuid());
    }

    public static function getUser(string $user) : ?User {
        return self::userExists($user) ? self::$users[$user] : null;
    }

    public static function userExists(string $user) : bool {
        return isset(self::$users[$user]);
    }

    public static function saveUsers() : void {
        foreach(self::$users as $row => $value) {
            $name = $value->getName();
            $xuid = $value->getXUID();
            if(empty(Main::getInstance()->getDb()->query("SELECT * FROM 'users' WHERE nick = '$name'")->fetchArray()))
                Main::getInstance()->getDb()->query("INSERT INTO 'users' (nick, xuid) VALUES ('$name', '$xuid')");
        }
    }

    public static function loadUsers() : void {
        $db = Main::getInstance()->getDb()->query("SELECT * FROM 'users'");

        $users = [];

        while($row = $db->fetchArray()) {
            if(is_string($row["nick"]) && is_string($row["xuid"]))
                $users[$row["nick"]] = new User($row["nick"], $row["xuid"]);
        }

        self::$users = $users;
    }

    public static function getUsers() : array {
        return self::$users;
    }

    public static function topPoinst(): array {
        $array = [];
        foreach (self::$users as $user) {
            $points = self::getUser($user->getName())->getPoints()->getPoints();
            $array[$user->getName()] = $points;

        }
        arsort($array);


        foreach (array_slice($array, 0, 10) as $name => $points) {
            //var_dump("NICK: ".$name." POINTS: ".$points." \n");
        }

        return $array;


    }
}






