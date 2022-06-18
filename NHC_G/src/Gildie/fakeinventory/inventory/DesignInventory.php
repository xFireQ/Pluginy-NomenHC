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

class DesignInventory extends FakeInventory {

    private string $tag;
    private int $color = 10;

    public function __construct(Player $player, string $tag) {
        parent::__construct($player, "§l§9PANEL GILDII");
        $this->tag = $tag;
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $this->setItem(0, \pocketmine\item\ItemFactory::getInstance()->get(53, 0));
        $this->setItem(1, \pocketmine\item\ItemFactory::getInstance()->get(67, 0));
        $this->setItem(2, \pocketmine\item\ItemFactory::getInstance()->get(108, 0));
        $this->setItem(3, \pocketmine\item\ItemFactory::getInstance()->get(109, 0));
        $this->setItem(4, \pocketmine\item\ItemFactory::getInstance()->get(114, 0));
        $this->setItem(5, \pocketmine\item\ItemFactory::getInstance()->get(128, 0));
        $this->setItem(6, \pocketmine\item\ItemFactory::getInstance()->get(134, 0));
        $this->setItem(7, \pocketmine\item\ItemFactory::getInstance()->get(135, 0));
        $this->setItem(8, \pocketmine\item\ItemFactory::getInstance()->get(136, 0));
        $this->setItem(9, \pocketmine\item\ItemFactory::getInstance()->get(156, 0));
        $this->setItem(10, \pocketmine\item\ItemFactory::getInstance()->get(163, 0));
        $this->setItem(11, \pocketmine\item\ItemFactory::getInstance()->get(164, 0));
        $this->setItem(12, \pocketmine\item\ItemFactory::getInstance()->get(180, 0));
        $this->setItem(13, \pocketmine\item\ItemFactory::getInstance()->get(203, 0));

        $this->setItem(18, \pocketmine\item\ItemFactory::getInstance()->get(44, 0));
        $this->setItem(19, \pocketmine\item\ItemFactory::getInstance()->get(44, 1));
        $this->setItem(20, \pocketmine\item\ItemFactory::getInstance()->get(44, 2));
        $this->setItem(21, \pocketmine\item\ItemFactory::getInstance()->get(44, 3));
        $this->setItem(22, \pocketmine\item\ItemFactory::getInstance()->get(44, 4));
        $this->setItem(23, \pocketmine\item\ItemFactory::getInstance()->get(44, 5));
        $this->setItem(24, \pocketmine\item\ItemFactory::getInstance()->get(44, 6));
        $this->setItem(25, \pocketmine\item\ItemFactory::getInstance()->get(44, 7));



    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        $guild = Main::getInstance()->getGuildManager()->getPlayerGuild($player->getName());
        $heartPosition = $guild->getHeartPos();
        $world = $player->getWorld();
        $id = $item->getId();
        $damage = $item->getMeta();
        //$heartPosition->add(0, -1, 0);
        if($item->getId() === 44) {
            $meta = $item->getMeta() + 8;
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(44, $meta));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(44, $meta));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()+1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get(44, $meta));
            $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()+1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get(44, $meta));





        }
        $ids = [53, 67, 108, 109, 144, 128, 134, 135, 136, 156, 163, 164, 180, 203];
        $i = 0;

        foreach ($ids as $id) {
            if($item->getId() == $id) {
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+1, $heartPosition->getZ()+1), BlockFactory::getInstance()->get($id, 6));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY(), $heartPosition->getZ()+2), BlockFactory::getInstance()->get($id, 6));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()-1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get($id, 2));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY()+1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get($id, 4));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY(), $heartPosition->getZ()+3), BlockFactory::getInstance()->get($id, 4));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()-1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get($id, 8));//8

                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+1, $heartPosition->getZ()-1), BlockFactory::getInstance()->get($id, 7));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY(), $heartPosition->getZ()-2), BlockFactory::getInstance()->get($id, 7));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()-1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get($id, 3));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY()+1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get($id, 5));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY(), $heartPosition->getZ()-3), BlockFactory::getInstance()->get($id, 5));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()-1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get($id, 1));//8

                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()+1, $heartPosition->getZ()+1), BlockFactory::getInstance()->get($id, 6));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY(), $heartPosition->getZ()+2), BlockFactory::getInstance()->get($id, 6));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-3, $heartPosition->getY()-1, $heartPosition->getZ()+2), BlockFactory::getInstance()->get($id, 2));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-1, $heartPosition->getY()+1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get($id, 5));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY(), $heartPosition->getZ()+3), BlockFactory::getInstance()->get($id, 5));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()-2, $heartPosition->getY()-1, $heartPosition->getZ()+3), BlockFactory::getInstance()->get($id, 1));//8

                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()+1, $heartPosition->getZ()-1), BlockFactory::getInstance()->get($id, 7));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY(), $heartPosition->getZ()-2), BlockFactory::getInstance()->get($id, 7));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+3, $heartPosition->getY()-1, $heartPosition->getZ()-2), BlockFactory::getInstance()->get($id, 3));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+1, $heartPosition->getY()+1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get($id, 4));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY(), $heartPosition->getZ()-3), BlockFactory::getInstance()->get($id, 4));
                $player->getWorld()->setBlock(new Vector3($heartPosition->getX()+2, $heartPosition->getY()-1, $heartPosition->getZ()-3), BlockFactory::getInstance()->get($id, 8));//8

            }

            $i++;
        }


        return true;
    }
}