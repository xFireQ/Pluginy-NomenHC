<?php

namespace Core\managers;

use Core\Main;

class Points {

    private int $points;
    private string $name;

    public function __construct(string $name, int $points = 1000) {
        $this->name = $name;
        $this->points = $points;
    }

    public function getPoints() : ?int {
        return $this->points;
    }

    public function setPoints(int $points) : void {
        $this->points = $points;
    }

}