<?php

namespace Core\command\commands\admin;


use pocketmine\command\{
    Command, CommandSender
};
use Core\task\VillagerTask;
use pocketmine\inventory\Inventory;
use pocketmine\item\Item;
use Core\command\BaseCommand;
use pocketmine\player\Player;
use pocketmine\Server;

use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\entity\Entity;
use pocketmine\level\Level;

use Core\Main;

class BossCommand extends BaseCommand {
    public function __construct() {
        parent::__construct("villager", "komenda villager", [], true, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $player = $sender;
        $this->spawn($player);
    }


    public function spawn(Player $player): void {
        $x = $player->getX();
        $y = $player->getY();
        $z = $player->getZ();

        $position = new Position($x, $y, $z, $player->getWorld());
        $nbt = Entity::createBaseNBT($position);
        $skin = $player->namedtag->getCompoundTag("Skin");
        $nbt->setTag($skin);
        $entity = Entity::createEntity("Villager", $player->getWorld(), $nbt);
        Main::getInstance()->getScheduler()->scheduleRepeatingTask(new VillagerTask(6, $entity), 20);
        $entity->setScale(1);
        $entity->setHealth(20);
        $entity->spawnToAll();
    }
}