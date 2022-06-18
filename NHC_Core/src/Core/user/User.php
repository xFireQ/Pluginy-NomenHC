<?php

namespace Core\user;

use Core\managers\Deposit;
use Core\managers\Points;
use Core\managers\Os;
use Core\drop\Drop;
use Core\Main;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\Server;

class User {

    private string $name;
    private string $xuid;
    private ?Deposit $deposit;
    private ?Points $points;
    private ?Drop $drop;
    private ?Os $os;
    private static array $vanish = [];
    public static $vanishTask;
    public static $tdTask;
    public static $lobbyTask;

    public function __construct(string $name, string $xuid) {
        $this->name = $name;
        $this->xuid = $xuid;

        $this->initDeposit();
        $this->initPoints();
        $this->initDrop();
        $this->initOs();
       // $this->initTd();
    }

    public function setVanish(bool $status) {
        self::$vanish[$this->name] = $status;
    }

    public function getVanish() {
        return in_array($this->name, self::$vanish) ? "WLACZONY" : "WYLACZONY";
    }

    /*private function initTd(): void
    {

        $td = new Turbodrop($this->name);

        if (!empty(($db = Main::getInstance()->getDb()->query("SELECT * FROM td WHERE nick = '" . $this->name . "'")->fetchArray(SQLITE3_ASSOC)))) {
            $td->setRefy($db["time"]);

        }

        $this->setDeposit($td);
    }

    public function saveTd(): void
    {
        if (!empty(Main::getInstance()->getDb()->query("SELECT * FROM td WHERE nick = '" . $this->name . "'")->fetchArray())) {
            Main::getInstance()->getDb()->query("UPDATE td SET time = '" . $this->turbodrop->getTime() . "' WHERE nick = '" . $this->name . "'");
        } else {
            Main::getInstance()->getDb()->query("INSERT INTO td (nick, time) VALUES ('" . $this->name . "', '" . $this->turbodrop->getTime() . "')");
        }
    }

    */


    private function initOs() : void {

        $os = new Os($this->name);

        if(!empty(($db = Main::getInstance()->getDb()->query("SELECT * FROM os WHERE nick = '".$this->name."'")->fetchArray(SQLITE3_ASSOC)))) {
            $os->setBreakStone($db["stone"]);
            $os->stoneClaim($db["stoneClaim"]);
        }

        $this->setOs($os);
    }

    public function saveOs() : void {
        if(!empty(Main::getInstance()->getDb()->query("SELECT * FROM os WHERE nick = '".$this->name."'")->fetchArray())) {
            Main::getInstance()->getDb()->query("UPDATE os SET stone = '".$this->os->getBreakStone()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE os SET stoneClaim = '".$this->os->stoneClaim()."' WHERE nick = '".$this->name."'");
        } else {
            Main::getInstance()->getDb()->query("INSERT INTO os (nick, stone, stoneClaim) VALUES ('".$this->name."', '".$this->os->getBreakStone()."', '".$this->os->stoneClaim()."')");
        }
    }




    private function initDeposit() : void {

        $deposit = new Deposit($this->name);

        if(!empty(($db = Main::getInstance()->getDb()->query("SELECT * FROM deposit WHERE nick = '".$this->name."'")->fetchArray(SQLITE3_ASSOC)))) {
            $deposit->setKoxy($db["koxy"]);
            $deposit->setRefy($db["refy"]);
            $deposit->setPerly($db["perly"]);
            $deposit->setSnow($db["snow"]);
            $deposit->setRzucak($db["rzucaki"]);
        }

        $this->setDeposit($deposit);
    }

    public function saveDeposit() : void {
        if(!empty(Main::getInstance()->getDb()->query("SELECT * FROM deposit WHERE nick = '".$this->name."'")->fetchArray())) {
            Main::getInstance()->getDb()->query("UPDATE deposit SET koxy = '".$this->deposit->getKoxy()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE deposit SET refy = '".$this->deposit->getRefy()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE deposit SET perly = '".$this->deposit->getPerly()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE deposit SET snow = '".$this->deposit->getSnow()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE deposit SET rzucaki = '".$this->deposit->getRzucak()."' WHERE nick = '".$this->name."'");
        } else {
            Main::getInstance()->getDb()->query("INSERT INTO deposit (nick, koxy, refy, perly, snow, rzucaki) VALUES ('".$this->name."', '".$this->deposit->getKoxy()."', '".$this->deposit->getRefy()."', '".$this->deposit->getPerly()."', '".$this->deposit->getSnow()."', '".$this->deposit->getRzucak()."')");
        }
    }

    private function initPoints() : void {

        $points = new Points($this->name);

        if(!empty(($db = Main::getInstance()->getDb()->query("SELECT * FROM points WHERE nick = '".$this->name."'")->fetchArray(SQLITE3_ASSOC)))) {
            $points->setPoints($db["points"]);
        }

        $this->setPoints($points);
    }

    public function savePoints() : void {
        if(!empty(Main::getInstance()->getDb()->query("SELECT * FROM points WHERE nick = '".$this->name."'")->fetchArray())) {
            Main::getInstance()->getDb()->query("UPDATE points SET points = '".$this->points->getPoints()."' WHERE nick = '".$this->name."'");
        } else {
            Main::getInstance()->getDb()->query("INSERT INTO points (nick, points) VALUES ('".$this->name."', '".$this->points->getPoints()."')");
        }
    }

    private function initDrop() : void {

        $drop = new Drop($this->name);

        if(!empty(($db = Main::getInstance()->getDb()->query("SELECT * FROM 'drop' WHERE nick = '".$this->name."'")->fetchArray(SQLITE3_ASSOC)))) {
            $drop->setDiamenty($db["diamenty"]);
            $drop->setEmeraldy($db["emeraldy"]);
            $drop->setZloto($db["zloto"]);
            $drop->setZelazo($db["zelazo"]);
            $drop->setPerly($db["perly"]);
            $drop->setTnt($db["tnt"]);
            $drop->setNicie($db["nicie"]);
            $drop->setSzlam($db["szlam"]);
            $drop->setObsydian($db["obsydian"]);
            $drop->setBiblioteczki($db["biblioteczki"]);
            $drop->setJablka($db["jablka"]);
            $drop->setWegiel($db["wegiel"]);
            $drop->setCobblestone($db["cobblestone"]);
        }

        $this->setDrop($drop);
    }

    public function saveDrop() : void {
        if(!empty(Main::getInstance()->getDb()->query("SELECT * FROM 'drop' WHERE nick = '".$this->name."'")->fetchArray())) {
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET diamenty = '".$this->drop->getDiamenty()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET emeraldy = '".$this->drop->getEmeraldy()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET zloto = '".$this->drop->getZloto()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET zelazo = '".$this->drop->getZelazo()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET perly = '".$this->drop->getPerly()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET tnt = '".$this->drop->getTnt()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET nicie = '".$this->drop->getNicie()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET szlam = '".$this->drop->getSzlam()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET obsydian = '".$this->drop->getObsydian()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET biblioteczki = '".$this->drop->getBiblioteczki()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET jablka = '".$this->drop->getJablka()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET wegiel = '".$this->drop->getWegiel()."' WHERE nick = '".$this->name."'");
            Main::getInstance()->getDb()->query("UPDATE 'drop' SET cobblestone = '".$this->drop->getCobblestone()."' WHERE nick = '".$this->name."'");
        } else {
            Main::getInstance()->getDb()->query("INSERT INTO 'drop' (nick, diamenty, emeraldy, zloto, zelazo, perly, tnt, nicie, szlam, obsydian, biblioteczki, jablka, wegiel, cobblestone) VALUES ('".$this->name."', '".$this->drop->getDiamenty()."', '".$this->drop->getEmeraldy()."', '".$this->drop->getZloto()."', '".$this->drop->getZelazo()."', '".$this->drop->getPerly()."', '".$this->drop->getTnt()."', '".$this->drop->getNicie()."', '".$this->drop->getSzlam()."', '".$this->drop->getObsydian()."', '".$this->drop->getBiblioteczki()."', '".$this->drop->getJablka()."', '".$this->drop->getWegiel()."', '".$this->drop->getCobblestone()."')");
        }
    }

    public function getName() : string {
        return $this->name;
    }

    public function getXUID() : string {
        return $this->xuid;
    }

    public function getDeposit() : ?Deposit {
        return $this->deposit;
    }

    public function setDeposit(?Deposit $dep) : void {
        $this->deposit = $dep;
    }

    public function getPoints() : ?Points {
        return $this->points;
    }

    public function setPoints(?Points $pkt) : void {
        $this->points = $pkt;
    }

    public function getDrop() : ?Drop {
        return $this->drop;
    }

    public function setDrop(?Drop $drop) : void {
        $this->drop = $drop;
    }

    public function getOs() : ?Os {
        return $this->os;
    }

    public function setOs(?Os $os) : void {
        $this->os = $os;
    }


}