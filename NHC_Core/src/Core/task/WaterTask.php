<?php

namespace Core\task;

use pocketmine\block\Block;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\scheduler\Task;
use pocketmine\Server;

class WaterTask extends Task {

    public function __construct(
        private Player $player,
        private Vector3 $vector3,
        private int $lastBlockId = 0
    ) {}

    public function onRun(): void{
        $player = $this->player;
        if($player == null) return;
        if(!$player->isOnline()) return;
        $playerContents = $player->getInventory()->getContents();
        $position = new Position($this->vector3->x, $this->vector3->y, $this->vector3->z);

        foreach ($playerContents as $item) {
            if($item->getId() === ItemIds::BUCKET && $item->getMeta() === 0) {
                $player->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::BUCKET, 0, 1));
                $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(ItemIds::BUCKET, 8, 1));
            }
        }
        Server::getInstance()->getWorldManager()->getDefaultWorld()->setBlock($position, BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::AIR));
    }
}