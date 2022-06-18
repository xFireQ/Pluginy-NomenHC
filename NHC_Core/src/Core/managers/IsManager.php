<?php

namespace Core\managers;

use pocketmine\block\SeaLantern;
use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class IsManager {

    private static array $services = [];
  
    public static function init() : void {
        Main::getDb()->query("CREATE TABLE IF NOT EXISTS uslugi (player TEXT, usluga TEXT, id INT)");
        self::loadServices();
    }

    public static function saveServices(): void {
        foreach (self::$services as $name => $services) {
            var_dump($services);
            var_dump($name);
            if(empty(Main::getDb()->query("SELECT * FROM uslugi WHERE player = '$name'")->fetchArray(SQLITE3_ASSOC))) {
                foreach ($services as $service) {
                    Main::getDb()->query("INSERT INTO uslugi (player, usluga, id) VALUES ('$name', '$service', '0')");
                }
            } else {
                foreach ($services as $service) {
                    Main::getDb()->query("UPDATE uslugi SET usluga = '$service' WHERE player = '$name'");
                    Main::getDb()->query("UPDATE uslugi SET id = '0' WHERE player = '$name' AND usluga = '$service'");
                }

            }
        }
    }

    public static function loadServices(): void {
        $db = Main::getDb()->query("SELECT * FROM uslugi");

        while ($row = $db->fetchArray(SQLITE3_ASSOC)) {
            $name = $row["player"];
            $service = $row["usluga"];
            $id = $row["id"];

            self::addUsluga($name, $service, $id);
        }
    }
    
    
    public static function addUsluga(string $nick, string $usluga, int $id) : void {
        $id = mt_rand(100, 1000000);
		self::$services[$nick][] = $usluga;
        var_dump(self::$services[$nick]);
	}

    public static function userExists(string $name): bool {
        return isset(self::$services[$name]);
    }

    public static function removeUsluga(string $nick, string $usluga) : void {
        $array = self::$services[$nick];
        //$services = self::$services[$nick];
        if (($key = array_search($usluga, $array)) !== false) {
            unset(self::$services[$nick][$key]);
        }
        var_dump($array);
    }

    public static function getUslugi(string $nick): array  {
        return self::$services[$nick];
    }
    
}