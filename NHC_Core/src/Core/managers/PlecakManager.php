<?php

namespace Core\managers;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class PlecakManager {

    private static $backpack = [];

    public static function init() : void {

        Main::getDb()->query("CREATE TABLE IF NOT EXISTS plecak (nick TEXT, msg TEXT, diamenty INT, zloto INT, zelazo INT, emeraldy INT, perly INT, tnt INT, nicie INT, szlam INT, obsydian INT, biblioteczki INT, jablka INT, wegiel INT, cobblestone INT)");
        self::loadUsersDrop();
    }

    public static function loadUsersDrop(): void {
        $db = Main::getDb()->query("SELECT * FROM 'plecak'");

        while ($row = $db->fetchArray(SQLITE3_ASSOC)) {
            $diamond = $row['diamenty'];
            $emerald = $row['emeraldy'];
            $iron = $row['zelazo'];
            $gold = $row['zloto'];
            $pearl = $row['perly'];
            $obs = $row['obsydian'];
            $coal = $row['wegiel'];
            $tnt = $row['tnt'];
            $apple = $row['jablka'];
            $book = $row['biblioteczki'];
            $string = $row['nicie'];
            $slime = $row['szlam'];
            $name = $row['nick'];
            $nick = $name;
            self::$backpack[$nick]["msg"] = "on";
            self::$backpack[$nick]["diamenty"] = $diamond;
            self::$backpack[$nick]["zloto"] = $gold;
            self::$backpack[$nick]["zelazo"] = $iron;
            self::$backpack[$nick]["emeraldy"] = $emerald;
            self::$backpack[$nick]["perly"] = $pearl;
            self::$backpack[$nick]["tnt"] = $tnt;
            self::$backpack[$nick]["nicie"] = $string;
            self::$backpack[$nick]["szlam"] = $slime;
            self::$backpack[$nick]["obsydian"] = $obs;
            self::$backpack[$nick]["biblioteczki"] = $book;
            self::$backpack[$nick]["jablka"] = $apple;
            self::$backpack[$nick]["wegiel"] = $coal;
            self::$backpack[$nick]["cobblestone"] = 0;

        }
    }

    public static function saveUsersDrop(): void {
        $database = Main::getDb();
        foreach (self::$backpack as $dropName => $items) {
            if(!empty($database->query("SELECT * FROM 'plecak' WHERE nick = '$dropName'")->fetchArray())) {
                $database->query("DELETE FROM 'plecak' WHERE nick = '$dropName'");
            }
        }

        foreach (self::$backpack as $dropName => $item) {
            foreach ($item as $count) {
                if(empty($database->query("SELECT * FROM 'plecak' WHERE nick = '$dropName'")->fetchArray())) {
                    $nick = $dropName;
                    $diax = PlecakManager::getCountItem($nick, "diamenty");
                    $gol = PlecakManager::getCountItem($nick, "zloto");
                    $iro = PlecakManager::getCountItem($nick, "zelazo");
                    $emeral = PlecakManager::getCountItem($nick, "emeraldy");
                    $countPerly = PlecakManager::getCountItem($nick, "perly");
                    $countTnt = PlecakManager::getCountItem($nick, "tnt");
                    $countNicie = PlecakManager::getCountItem($nick, "nicie");
                    $countSzlam = PlecakManager::getCountItem($nick, "szlam");
                    $countObsydian = PlecakManager::getCountItem($nick, "obsydian");
                    $countBiblioteczki = PlecakManager::getCountItem($nick, "biblioteczki");
                    $countJablka = PlecakManager::getCountItem($nick, "jablka");
                    $countWegiel = PlecakManager::getCountItem($nick, "wegiel");
                    $countCobblestone = PlecakManager::getCountItem($nick, "cobblestone");

                    $database->query("INSERT INTO 'plecak' ('nick', 'diamenty', 'zloto', 'zelazo', 'emeraldy', 'perly', 'tnt', 'nicie', 'szlam', 'obsydian', 'biblioteczki', 'jablka', 'wegiel', 'cobblestone') VALUES ('$dropName', '$diax', '$gol', '$iro', '$emeral', '$countPerly', '$countTnt', '$countNicie', '$countSzlam', '$countObsydian', '$countBiblioteczki', '$countJablka', '$countWegiel', '$countCobblestone')");
                }
            }
        }
    }

    public static function setDefault(Player $player) : void {
        $nick = $player->getName();
        if(!isset(self::$backpack[$nick])) {
            self::$backpack[$nick]["msg"] = "on";
            self::$backpack[$nick]["diamenty"] = 0;
            self::$backpack[$nick]["zloto"] = 0;
            self::$backpack[$nick]["zelazo"] = 0;
            self::$backpack[$nick]["emeraldy"] = 0;
            self::$backpack[$nick]["perly"] = 0;
            self::$backpack[$nick]["tnt"] = 0;
            self::$backpack[$nick]["nicie"] = 0;
            self::$backpack[$nick]["szlam"] = 0;
            self::$backpack[$nick]["obsydian"] = 0;
            self::$backpack[$nick]["biblioteczki"] = 0;
            self::$backpack[$nick]["jablka"] = 0;
            self::$backpack[$nick]["wegiel"] = 0;
            self::$backpack[$nick]["cobblestone"] = 0;
        }
        // Main::getDb()->query("INSERT INTO plecak (nick, msg, diamenty, zloto, zelazo, emeraldy, perly, tnt, nicie, szlam, obsydian, biblioteczki, jablka, wegiel, cobblestone) VALUES ('$nick', 'on', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0', '0')");
        //var_dump("SET DEFAULT <=============================");
        //var_dump(self::$backpack);
    }

    public static function setOn(string $nick) : void {
        self::$backpack[$nick]["msg"] = "on";
    }

    public static function setOff(string $nick) : void {
        self::$backpack[$nick]["msg"] = "off";
    }

    public static function getStatus(Player $player)  {
        $nick = $player->getName();
        //var_dump(self::$backpack[$nick]["msg"]);

        return self::$backpack[$nick]["msg"];
    }

    public static function addItem(string $nick, int $count, string $item) : void {
        //$count = PlecakManager::getCountItem($nick, $item) + $count;
        self::$backpack[$nick][$item] = self::$backpack[$nick][$item] + $count;
        //var_dump("ADD ITEM <=============================");
       // var_dump(self::$backpack);
        //Main::getDb()->query("UPDATE plecak SET $item = '$count' WHERE nick = '$nick'");
    }

    public static function removeItem(string $nick, int $count, string $item) : void {
        /*$count = PlecakManager::getCountItem($nick, $item) - $count;

        if($count < 0)
            $count = 0;*/

        self::$backpack[$nick][$item] = self::$backpack[$nick][$item] - $count;
        //var_dump("REMOVE ITEM <=============================");
        //var_dump(self::$backpack);

        // Main::getDb()->query("UPDATE plecak SET $item = '$count' WHERE nick = '$nick'");
    }




    public static function getCountItem(string $nick, string $item) :?int  {
        //var_dump("COUNT ITEM <=============================");
        //var_dump(self::$backpack);
        return self::$backpack[$nick][$item];
    }

}




