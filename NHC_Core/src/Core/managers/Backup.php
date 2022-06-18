<?php

namespace Core\managers;

class Backup {

    private string $name;

    private string $date;
    private string $killer;
    private int $perly;

    public function __construct(string $name, int $koxy = 0, int $refy = 0, int $perly = 0) {
        $this->name = $name;
        $this->koxy = $koxy;
        $this->refy = $refy;
        $this->perly = $perly;
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