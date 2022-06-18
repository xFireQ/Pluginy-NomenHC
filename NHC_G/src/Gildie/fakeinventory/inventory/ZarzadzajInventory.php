<?php

declare(strict_types=1);

namespace Gildie\fakeinventory\inventory;

use Gildie\fakeinventory\FakeInventory;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\block\Block;
use pocketmine\inventory\Inventory;
use Gildie\Main;

class ZarzadzajInventory extends FakeInventory {

    private $db;
    private $g;

    public function __construct(Player $player) {
        $nick = $player->getName();
        $guildManager = Main::getInstance()->getGuildManager();

        $guild = $guildManager->getPlayerGuild($nick);

        $tag = $guild->getTag();
        $this->db = Main::getInstance()->getDb();
        $this->g = $tag;

        parent::__construct($player, "§l§9PANEL §r§8- [§l§9" . $tag . "§r§8]");



        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $sender = $player;

        $guildManager = Main::getInstance()->getGuildManager();

        $i = 0;
        $guild = $guildManager->getPlayerGuild($sender->getName());
        $e = $guild->getTag();
        $array = $this->db->query("SELECT * FROM players WHERE guild = '$e'");;
        while ($row = $array->fetchArray(SQLITE3_ASSOC)) {
            $name = $row["player"];
            $rank = $row["rank"];
            //$rank = $this->plugin->getRankAsString2($name);
            // if ($name != $player->getName()) {
            if ($rank == "Leader") {
                $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOB_HEAD, 3, 1);
                $item->setCustomName("§r§8» §7Lider:§9§l " . $name);
            } else {
                if($rank == "Officer") {
                    $item->setCustomName("§r§8» §7Oficer:§9§l " . $name);
                } else {
                    $item->setCustomName("§r§8» §7Czlonek:§9§l " . $name);
                }
            }
            $leader = $guild->getLeader();
            // $lider = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOB_HEAD, 3, 1);

            // $lider->setCustomName("§r§8» §7Lider:§c§l " . $leader);

            $this->setItem($i, $item);
            $i++;
            // $this->setItemAt(6, 2, $info);
            // $this->setItemAt(9, 3, $cofnij);
            // $this->setItemAt(5, 3, $zarzadzaj);
            //$this->setItemAt(4, 5, $przedluz);
            // $this->setItemAt(6, 5, $powieksz);
            // }

        }

    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        $sender = $player;
        $guildManager = Main::getInstance()->getGuildManager();

        $guild = $guildManager->getPlayerGuild($sender->getName());
        $e = $guild->getTag();

        $nick = $sender->getName();

        if($item->getId() == \pocketmine\item\ItemIds::MOB_HEAD) {
            $player->sendMessage("Aktualnie ta funkcja jest wylaczona!");
            /* $array = $this->db->query("SELECT * FROM players WHERE guild = '$e'");;
             while ($row = $array->fetchArray(SQLITE3_ASSOC)) {
                 $name = $row["player"];
                 $rank = $row["rank"];

                 if($rank == "Leader") {

                    // $this->openFakeInventory($player, new PermisjeInventory($player, $name));
                     return true;
                 } else {
                     $player->sendMessage("§cNie mozesz tego zrobic!");
                   // $this->openFakeInventory($player, new PermisjeInventory($player, $name));
                 }

         }*/


            return true;
        }
    }
}