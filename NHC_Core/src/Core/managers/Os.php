<?php

namespace Core\managers;

class Os {

    private string $name;

    private int $stone;
    private string $stoneClaim;

    public function __construct(string $name, int $stone = 0, string $stoneClaim = "BRAK") {
        $this->name = $name;
        $this->stone = $stone;
        $this->stoneClaim = $stoneClaim;
    }

    public function getBreakStone() : ?int {
        return $this->stone;
    }

    public function setBreakStone(int $stone) {
        $this->stone = $stone;
    }

    public function stoneClaim(string $id) {
        return $this->stoneClaim;
    }

    public function setStoneClaim(string $stoneClaim) {
        $this->stoneClaim = $stoneClaim;
    }
}