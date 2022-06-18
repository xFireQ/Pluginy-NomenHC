<?php

namespace Core\drop;

use Core\Main;
use Core\user\User;

class Drop {

    private string $name;
    private string $diamenty;
    private string $emeraldy;
    private string $zloto;
    private string $zelazo;
    private string $perly;
    private string $tnt;
    private string $nicie;
    private string $szlam;
    private string $obsydian;
    private string $biblioteczki;
    private string $jablka;
    private string $wegiel;
    private string $cobblestone;
    private int $time;

    public function __construct(string $name, string $diamenty = "on", string $emeraldy = "on", string $zloto = "on", string $zelazo = "on", string $perly = "on", string $tnt = "on", string $nicie = "on", string $szlam = "on", string $obsydian = "on", string $biblioteczki = "on", string $jablka = "on", string $wegiel = "on", string $cobblestone = "on", int $time = 0) {
        $this->diamenty = $diamenty;
        $this->emeraldy = $emeraldy;
        $this->zloto = $zloto;
        $this->zelazo = $zelazo;
        $this->perly = $perly;
        $this->tnt = $tnt;
        $this->nicie = $nicie;
        $this->szlam = $szlam;
        $this->obsydian = $obsydian;
        $this->biblioteczki = $biblioteczki;
        $this->jablka = $jablka;
        $this->wegiel = $wegiel;
        $this->cobblestone = $cobblestone;
        $this->time = $time;
        $this->name = $name;
    }

    public function setAllOn(string $diamenty = "on", string $emeraldy = "on", string $zloto = "on", string $zelazo = "on", string $perly = "on", string $tnt = "on", string $nicie = "on", string $szlam = "on", string $obsydian = "on", string $biblioteczki = "on", string $jablka = "on", string $wegiel = "on", string $cobblestone = "on") {
        $this->diamenty = $diamenty;
        $this->emeraldy = $emeraldy;
        $this->zloto = $zloto;
        $this->zelazo = $zelazo;
        $this->perly = $perly;
        $this->tnt = $tnt;
        $this->nicie = $nicie;
        $this->szlam = $szlam;
        $this->obsydian = $obsydian;
        $this->biblioteczki = $biblioteczki;
        $this->jablka = $jablka;
        $this->wegiel = $wegiel;
        $this->cobblestone = $cobblestone;
    }

    public function setAllOff(string $diamenty = "off", string $emeraldy = "off", string $zloto = "off", string $zelazo = "off", string $perly = "off", string $tnt = "off", string $nicie = "off", string $szlam = "off", string $obsydian = "off", string $biblioteczki = "off", string $jablka = "off", string $wegiel = "off", string $cobblestone = "off") {
        $this->diamenty = $diamenty;
        $this->emeraldy = $emeraldy;
        $this->zloto = $zloto;
        $this->zelazo = $zelazo;
        $this->perly = $perly;
        $this->tnt = $tnt;
        $this->nicie = $nicie;
        $this->szlam = $szlam;
        $this->obsydian = $obsydian;
        $this->biblioteczki = $biblioteczki;
        $this->jablka = $jablka;
        $this->wegiel = $wegiel;
        $this->cobblestone = $cobblestone;
    }

    public function getDropItem(string $item) : ?string {
        return $this->$item;
    }

    public function setDropItem(string $item, string $status) : void {
        $this->$item = $status;
    }

    public function setDiamenty(string $status) : void {
        $this->diamenty = $status;
    }

    public function setEmeraldy(string $status) : void {
        $this->emeraldy = $status;
    }

    public function setZloto(string $status) : void {
        $this->zloto = $status;
    }

    public function setZelazo(string $status) : void {
        $this->zelazo = $status;
    }

    public function setPerly(string $status) : void {
        $this->perly = $status;
    }

    public function setTnt(string $status) : void {
        $this->tnt = $status;
    }

    public function setNicie(string $status) : void {
        $this->nicie = $status;
    }

    public function setSzlam(string $status) : void {
        $this->szlam = $status;
    }

    public function setObsydian(string $status) : void {
        $this->obsydian = $status;
    }

    public function setBiblioteczki(string $status) : void {
        $this->biblioteczki = $status;
    }

    public function setJablka(string $status) : void {
        $this->jablka = $status;
    }

    public function setWegiel(string $status) : void {
        $this->wegiel = $status;
    }

    public function setCobblestone(string $status) : void {
        $this->cobblestone = $status;
    }

    public function getDiamenty() : ?string {
        return $this->diamenty;
    }

    public function getEmeraldy() : ?string {
        return $this->emeraldy;
    }

    public function getZloto() : ?string {
        return $this->zloto;
    }

    public function getZelazo() : ?string {
        return $this->zelazo;
    }

    public function getPerly() : ?string {
        return $this->perly;
    }

    public function getTnt() : ?string {
        return $this->tnt;
    }

    public function getNicie() : ?string {
        return $this->nicie;
    }

    public function getSzlam() : ?string {
        return $this->szlam;
    }

    public function getObsydian() : ?string {
        return $this->obsydian;
    }

    public function getBiblioteczki() : ?string {
        return $this->biblioteczki;
    }

    public function getJablka() : ?string {
        return $this->jablka;
    }

    public function getWegiel() : ?string {
        return $this->wegiel;
    }

    public function getCobblestone() : ?string {
        return $this->cobblestone;
    }

    public function getTime(): ?int {
        return $this->time;
    }

    public function setTime(int $time) : void {
        $this->time = $time;
    }

    public function getTurbodrop(string $name): ?string
    {
        $status = "cOFF";
        if(!empty(User::$tdTask[$name])) {
            $status = "aON";
        } else {
            $status = "cOFF";
        }


        return $status;
    }

}