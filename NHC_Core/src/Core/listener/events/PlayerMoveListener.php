<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\user\UserManager;
use pocketmine\entity\Effect;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\entity\EffectInstance;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\level;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use Core\managers\SchowekManager;
use Core\Main;
use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\player\PlayerInfo;
use raklib\server\Session;

class PlayerMoveListener implements Listener {

    public $coords = array(
        "pos1" => array(
            "x" => -72,
            "z" => 51
        ),

        "pos2" => array(
            "x" => 71,
            "z" => -73
        ),
    );

    public function border(PlayerMoveEvent $e)
    {
        $player = $e->getPlayer();

        $x = $player->getPosition()->getFloorX();
        $z = $player->getPosition()->getFloorZ();

        $border = floor(1200 / 2);

        if (abs($x) >= ($border - 15)) {
            $distance = 15 - (abs($x) - ($border - 15));
            $player->sendTip("§7Do konca borderu zostalo: §9" . $distance . " §7kratek");
            //$player->sendTitle("§r§c§lBORDER", "§r§7Do konca borderu zostalo §c{$distance} §7kratek!");
        }

        if (abs($z) >= ($border - 15)) {
            $distance = 15 - (abs($z) - ($border - 15));
            //$player->sendTip("§7Do konca borderu: §2" . $distance);
            $player->sendTip("§7Do konca borderu zostalo: §9" . $distance . " §7kratek");
            //$player->sendTitle("§r§c§lBORDER", "§r§7Do konca borderu zostalo §c{$distance} §7kratek!");
        }

        if ($x >= $border)
            $player->knockBack($player, 0, -2, 0, 0.5);

        if ($x <= -$border)
            $player->knockBack($player, 0, 2, 0, 0.5);

        if ($z >= $border)
            $player->knockBack($player, 0, 0, -2, 0.5);

        if ($z <= -$border)
            $player->knockBack($player, 0, 0, 2, 0.5);
    }

    public function areaKnock(PlayerMoveEvent $event){
        $player = $event->getPlayer();
        $nick = $player->getName();
        if (isset(Main::$antylogoutPlayers[$nick])) {
            if($player->getZ() <  51 and $player->getZ() > -73){
                if($player->getX() < 71 and $player->getX() > -72){
                    $to = $event->getTo();
                    $spawn = new Vector3(0, $player->getY(), 0);
                    $player->knockBack($player, 0, $to->getX() - $spawn->getX(), $to->getZ() - $spawn->getZ(), 1);
                }
            }
        }
    }


    public function onMove(PlayerMoveEvent $e) : void
    {

        $gracz = $e->getPlayer();
        $player = $gracz;
        $nick = $gracz->getName();
        $user = UserManager::getUser($nick)->getDeposit();
        $iloscK = 0;
        $iloscR = 0;
        $iloscP = 0;
        $iloscS = 0;
        $iloscRz = 0;

        foreach ($gracz->getInventory()->getContents() as $item) {
            if ($item->getId() == 466) {
                $iloscK += $item->getCount();
            }
            if ($item->getId() == 322) {
                $iloscR += $item->getCount();
            }
            if ($item->getId() == 368) {
                $iloscP += $item->getCount();
            }
            if ($item->getId() == 52) {
                $iloscRz += $item->getCount();
            }

            if ($item->getId() == 332) {
                $iloscS += $item->getCount();
            }
            if ($iloscK > 1) {
                $iloscK = $iloscK - 1;
                $gracz->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(466, 0, $iloscK));
                $gracz->sendMessage(Main::format("Twoj nadmiar koxow zostal przeniesiony do schowka"));


                $user->setKoxy($iloscK + $user->getKoxy());
                return;
            }
            if ($iloscR > 6) {
                $iloscR = $iloscR - 6;
                $gracz->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(322, 0, $iloscR));
                $gracz->sendMessage(Main::format("Twoj nadmiar refow zostal przeniesiony do schowka"));
                $user->setRefy($iloscR + $user->getRefy());
                return;
            }
            if ($iloscP > 3) {
                $iloscP = $iloscP - 3;
                $gracz->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(368, 0, $iloscP));
                $gracz->sendMessage(Main::format("Twoj nadmiar perel zostal przeniesiony do schowka"));
                $user->setPerly($iloscP + $user->getPerly());
                return;
            }

            if ($iloscS > 8) {
                $iloscS = $iloscS - 8;
                $gracz->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(332, 0, $iloscS));
                $gracz->sendMessage(Main::format("Twoj nadmiar sniezek zostal przeniesiony do schowka"));
                $user->addSnow($iloscS);
                return;
            }

            if ($iloscRz > 3) {
                $iloscRz = $iloscRz - 3;
                $gracz->getInventory()->removeItem(\pocketmine\item\ItemFactory::getInstance()->get(52, 0, $iloscRz));
                $gracz->sendMessage(Main::format("Twoj nadmiar rzucakow zostal przeniesiony do schowka"));
                $user->addRzucak($iloscRz);
                return;
            }


        }
    }

    public function SpawnMoveCancel(PlayerMoveEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        if (isset(Main::$spawnTask[$nick])) {
            if (!($e->getTo()->floor()->equals($e->getFrom()->floor()))) {

                Main::$spawnTask[$nick]->cancel();

                unset(Main::$spawnTask[$nick]);

                $player->sendMessage(Main::format("§7Teleportacja na spawn zostala przerwana poniewaz sie poruszyles!"));
                $player->sendTitle("§l§9Spawn", "§7Teleportacja na spawn przerwana!");

                $player->removeEffect(9);
            }
        }
    }

    public function tpMoveCancel(PlayerMoveEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        if (isset(Main::$tpTask[$nick])) {
            if (!($e->getTo()->floor()->equals($e->getFrom()->floor()))) {

                Main::$tpTask[$nick]->cancel();

                unset(Main::$tpTask[$nick]);

                $player->sendMessage("§cTELEPORTACJA ZOSTALA PRZERWANA!");

                $player->removeEffect(9);
            }
        }
    }

    public function homeMoveCancel(PlayerMoveEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        if (isset(Main::$homeTask[$nick])) {
            if (!($e->getTo()->floor()->equals($e->getFrom()->floor()))) {
                Main::$homeTask[$nick]->cancel();
                unset(Main::$homeTask[$nick]);
                $player->sendMessage("§7Teleportacja do domu zostala przerwana!");
                $player->getEffects()->remove(9);
            }
        }
    }


}