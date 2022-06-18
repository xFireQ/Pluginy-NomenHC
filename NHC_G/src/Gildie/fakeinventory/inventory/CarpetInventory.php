<?php

declare(strict_types=1);

namespace Gildie\fakeinventory\inventory;

use Gildie\fakeinventory\FakeInventory;
use Gildie\guild\GuildManager;
use pocketmine\block\BlockFactory;
use pocketmine\item\Item;
use pocketmine\math\Vector3;
use pocketmine\player\Player;
use pocketmine\block\Block;
use Gildie\Main;
use pocketmine\inventory\Inventory;
use pocketmine\Server;

class CarpetInventory extends FakeInventory {

    private string $tag;
    private int $color = 10;

    public function __construct(Player $player, string $tag) {
        parent::__construct($player, "§l§9PANEL GILDII");
        $this->tag = $tag;
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $this->setItem(0, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 0));
        $this->setItem(1, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 1));
        $this->setItem(2, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 2));
        $this->setItem(3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 3));
        $this->setItem(4, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 4));
        $this->setItem(5, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 5));
        $this->setItem(6, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 6));
        $this->setItem(7, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 7));
        $this->setItem(8, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 8));
        $this->setItem(9, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 9));
        $this->setItem(10, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 10));
        $this->setItem(11, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 11));
        $this->setItem(12, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 12));
        $this->setItem(13, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 13));
        $this->setItem(14, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 14));
        $this->setItem(15, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 15));



    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        if($item->getId() === \pocketmine\item\ItemIds::CARPET) {
            $guild = Main::getInstance()->getGuildManager()->getPlayerGuild($player->getName());
            $heartPosition = $guild->getHeartPos();
            $world = $player->getWorld();
            $damage = $item->getMeta();

            $world->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY() - 1, $heartPosition->getZ()), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $world->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY() - 1, $heartPosition->getZ()), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $world->setBlock(new Vector3($heartPosition->getX(), $heartPosition->getY() - 1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $world->setBlock(new Vector3($heartPosition->getX(), $heartPosition->getY() - 1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $world->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY() - 1, $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $world->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY() - 1, $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $world->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY() - 1, $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY() - 1, $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY() - 1, $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY() - 1, $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY() - 1, $heartPosition->getZ()-1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY() - 1, $heartPosition->getZ()+1), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY() - 1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY() - 1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY() - 1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY() - 1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, $damage));
        }
        return true;
    }
}