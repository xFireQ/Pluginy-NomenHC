<?php

namespace Core\vanish;

use Core\Main;

class Vanish {

    private string $vanish;
    private string $name;

    public function __construct(string $name, bool $vanish = false) {
        $this->vanish = $vanish;
        $this->name = $name;
    }

    public function getVanishStatus() {
        return $this->vanish;
    }

    public function getName(){
        return $this->name;
    }


}