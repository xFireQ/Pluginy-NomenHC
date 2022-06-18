<?php

declare(strict_types=1);

namespace Gildie\fakeinventory\inventory;

use Gildie\fakeinventory\FakeInventory;
use Gildie\fakeinventory\FakeInventorySize;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\player\Player;
use pocketmine\block\Block;
use Gildie\Main;

class PanelInventory extends FakeInventory {



    public function __construct(Player $player) {
        $nick = $player->getName();
        $guildManager = Main::getInstance()->getGuildManager();

        $guild = $guildManager->getPlayerGuild($nick);

        $tag = $guild->getTag();

        parent::__construct($player, "§r§9PANEL GILDI §r§8- [§l§9" . $tag . "§r§8]", FakeInventorySize::LARGE_CHEST);



        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        $sender = $player;

        $guildManager = Main::getInstance()->getGuildManager();


        $guild = $guildManager->getPlayerGuild($sender->getName());

        $tag = $guild->getTag();
        $name = $guild->getName();
        $leader = $guild->getLeader();
        $lifes = $guild->getLifes();
        $expiryDate = $guild->getExpiryDate();
        $points = $guild->getPoints();
        $rankPlace = $guild->getRankPlace();

        $expiryH = 0;
        $expiryM = 0;
        $expiryS = 0;

        if(!$guild->canConquer()) {
            $exipiryTime = strtotime($guild->getConquerDate()) - time();

            $expiryH = floor($exipiryTime / 3600);
            $expiryM = floor(($exipiryTime / 60) % 60);
            $expiryS = $exipiryTime % 60;
        }

        $members = "";

        foreach($guild->getPlayers() as $nick) {
            $Fnick = $nick;

            if($nick === $guild->getLeader() || $nick === $guild->getOfficer())
                $Fnick = "§l".$Fnick;

            if($sender->getServer()->getPlayerExact($nick))
                $members .= "§a".$Fnick."§r§8, ";
            else
                $members .= "§9".$Fnick."§8, ";
        }

        $members = substr($members, 0, strlen($members) - 2);

        $alliances = "";

        foreach($guild->getAlliances() as $tag) {
            $aGuild = $guildManager->getGuildByTag($tag);

            $alliances .= "§8[§6{$aGuild->getTag()}§8] §6{$aGuild->getName()}§7, ";
        }

        if($alliances === "")
            $alliances = "§9BRAK";
        else
            $alliances = substr($alliances, 0, strlen($alliances) - 2);

        /* $sender->sendMessage(" \n§8          §2LightPE\n\n");
         $sender->sendMessage("§8§l»§r §7Tag: §8[§2{$tag}§8]");
         $sender->sendMessage("§8§l»§r §7Nazwa:§2 $name");
         $sender->sendMessage("§8§l»§r §7Zalozyciel:§2 $leader");
         $sender->sendMessage("§8§l»§r §7Ranking: §2$points");
         $sender->sendMessage("§8§l»§r §7Miejsce w rankingu: §2$rankPlace");
         $sender->sendMessage("§8§l»§r §7Zycia: §2$lifes");
         $sender->sendMessage("§8§l»§r §7Mozna podbic za: §2$expiryH §7godzin, §2$expiryM §7minut i §2$expiryS §7sekund");
         $sender->sendMessage("§8§l»§r §7Waznosc: §2$expiryDate");
         $sender->sendMessage("§8§l»§r §7Czlonkowie: $members");
         $sender->sendMessage("§8§l»§r §7Sojusze: $alliances");
         $sender->sendMessage(" \n");*/


        $item = \pocketmine\item\ItemFactory::getInstance()->get(339, 0, 1);
        $item->setCustomName("§r§l§9GILDIA §r§8[§9{$tag}§8] - [§9{$name}§8]");
        $item->setLore(["§r§8» §7Lider: §9{$leader} \n§r§8» §7Zycia: §9{$lifes} \n§r§8» §7Ranking:§9 {$points} \n§r§8» §7Czlonkowie: {$members} \n§r§8» §7Soujsze: {$alliances}"]);
        $itemB = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BARS);

        $zarzadzaj = \pocketmine\item\ItemFactory::getInstance()->get(397, 3, 1);
        $zarzadzaj->setCustomName("§r§l§9ZARZADZAJ CZLONKAMI");
        $powieksz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_INGOT);
        $powieksz->setCustomName("§r§l§9POWIEKSZ GILDIE");
        $powieksz->setLore(["§r§8» §aTwoja gildia jest powiekszona"]);
        $przedluz = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT);
        $przedluz->setCustomName("§r§l§9PRZEDLUZ GILDIE");

        for($i = 1; $i < 10; $i++) {
            $this->setItemAt($i, 1, $itemB);
            $this->setItemAt($i, 6, $itemB);
        }

        for($i = 1; $i < 7; $i++) {
            $this->setItemAt(1, $i, $itemB);
            $this->setItemAt(9, $i, $itemB);
        }

        $this->setItemAt(5, 1, $item);
        $this->setItemAt(5, 3, $zarzadzaj);
        $this->setItemAt(4, 5, $przedluz);
        $this->setItemAt(6, 5, $powieksz);
        $this->setItemAt(3, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::CARPET, 2)->setCustomName("§r§l§9ZMIEN DYWAN"));
        $this->setItemAt(7, 3, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE_BRICK_STAIRS)->setCustomName("§r§l§9ZMIEN DIZAJN"));


    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot): bool {
        $item = $sourceItem;
        $guildManager = Main::getInstance()->getGuildManager();
        $nick = $player->getName();
        $guild = $guildManager->getPlayerGuild($nick);

        if($item->getId() == 397) {
            if($guild->getPlayerRank($nick) == "Leader") {
                $this->openFakeInventory($player, new ZarzadzajInventory($player));

            }
        }

        if($item->getId() == ItemIds::CARPET) {
            $this->changeInventory($player, new CarpetInventory($player, $guild->getTag()));
        }

        if($item->getId() == ItemIds::STONE_BRICK_STAIRS) {
            $this->changeInventory($player, new DesignInventory($player, $guild->getTag()));
        }

        if($item->getId() == \pocketmine\item\ItemIds::IRON_INGOT) {
            $sender = $player;

            $guildManager = Main::getInstance()->getGuildManager();

            $nick = $sender->getName();

            $guild = $guildManager->getPlayerGuild($nick);

            //if($guild->getPlayerRank($nick) == "Leader") {
            //$gui = new PrzedluzInventory($sender);
            //$gui->setItems($sender);
            //$gui->openFor($sender);
            $this->changeInventory($player, new PrzedluzInventory($player));
            // } else {


            //$sender->sendMessage(Main::format("Musisz byc liderem albo zastepca gildii aby to zrobic!"));




            //(new PrzedluzInventory($sender))->openFor($sender);
        }
        return true;
    }
}