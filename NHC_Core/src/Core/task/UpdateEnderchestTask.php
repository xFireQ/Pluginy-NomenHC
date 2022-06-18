<?php

declare(strict_types=1);

namespace Core\task;

use Core\fakeinventory\inventory\EnderchestInventory;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use Core\Main;
use pocketmine\Server;

class UpdateEnderchestTask extends Task {

    private $player;
    private $inv;

    public function __construct(Player $player, EnderchestInventory $inv) {
        $this->player = $player;
        $this->inv = $inv;
    }

    public function onRun(): void {
        $this->inv->getName()->saveSkarbiecItems($this->inv);
        $this->inv->onTransaction($this->player, null);
        $this->inv->getName()->setCanSkarbiecTransaction($this->player, true);
    }
}