<?php

namespace Core\managers;

class Deposit {

    private string $name;

    private int $koxy;
    private int $refy;
    private int $perly;
    private int $snow;
    private int $rzucak;

    public function __construct(string $name, int $koxy = 0, int $refy = 0, int $perly = 0, int $snow = 0, int $rzucak = 0) {
        $this->name = $name;
        $this->koxy = $koxy;
        $this->refy = $refy;
        $this->perly = $perly;
        $this->snow = $snow;
        $this->rzucak = $rzucak;
    }

    public function getKoxy() : ?int {
        return $this->koxy;
    }

    public function getRefy() : ?int {
        return $this->refy;
    }

    public function getPerly() : ?int {
        return $this->perly;
    }

    public function getSnow(): ?int {
        return $this->snow;
    }

    public function getRzucak(): ?int {
        return $this->rzucak;
    }

    public function setSnow(int $snow) {
        $this->snow = $snow;
    }

    public function addSnow(int $snow) {
        $this->snow = $this->snow + $snow;
    }

    public function addRzucak(int $rzucak) {
        $this->rzucak = $this->rzucak + $rzucak;
    }

    public function setRzucak(int $rzucak) {
        $this->rzucak = $rzucak;
    }

    public function setKoxy(int $koxy) {
        $this->koxy = $koxy;
    }

    public function setRefy(int $refy) {
        $this->refy = $refy;
    }

    public function setPerly(int $perly) {
        $this->perly = $perly;
    }
}