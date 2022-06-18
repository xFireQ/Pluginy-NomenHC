<?php

namespace Core\managers;

use Core\Main;

class Points {

    private int $points;
    private string $name;

    public function __construct(string $name, int $points = 500) {
        $this->name = $name;
        $this->points = $points;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    public function getPoints() : ?int {
        return $this->points;
    }

    public function setPoints(int $points) : void {
        $this->points = $points;
    }

}