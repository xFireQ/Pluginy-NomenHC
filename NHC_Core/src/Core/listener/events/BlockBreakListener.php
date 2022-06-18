<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\drop\DropManager;
use Core\task\GamemodeTask;
use Core\task\StoniarkaTask;
use Core\user\UserManager;
use Core\format\Permission;
use pocketmine\block\Block;
use pocketmine\event\inventory\InventoryTransactionEvent;
use Core\guild\GuildManager;
use pocketmine\item\Item;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\player\GameMode;
use pocketmine\Server;
use pocketmine\event\Listener;
use Core\Main;
use Core\managers\PlecakManager;
use Core\managers\ProtectManager;
use Core\util\FormatUtils;
use Core\util\GlobalVariables;
use pocketmine\player\Player;

class BlockBreakListener implements Listener
{

    public function terrainBlockBreak(BlockBreakEvent $e)
    {

        $player = $e->getPlayer();
        $block = $e->getBlock();

        if(Permission::isOp($player) or $player->getGamemode() == GameMode::CREATIVE()) return;

        if($e->isCancelled()) {
            $player->setGamemode(GameMode::ADVENTURE());
            Main::getInstance()->getScheduler()->scheduleRepeatingTask(new GamemodeTask(4, $player), 20);

        }

        if (!ProtectManager::canBreak($player, $block))
            $e->cancel(true);

    }

    public function terrainWhiteBlocks(BlockBreakEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        $block = $e->getBlock();

        if (isset(GlobalVariables::$setWhiteBlock[$nick])) {
            $e->cancel(true);
            $terrainName = GlobalVariables::$setWhiteBlock[$nick];
            ProtectManager::addWhiteBlock($terrainName, $block);
            $player->sendMessage(Main::format("§7Dodano ten blok do listy bialych blokow"));
        } elseif (isset(GlobalVariables::$removeWhiteBlock[$nick])) {
            $e->cancel(true);
            $terrainName = GlobalVariables::$removeWhiteBlock[$nick];
            ProtectManager::removeWhiteBlock($terrainName, $block);
            $player->sendMessage(Main::format("§7Usunieto ten blok z listy bialych blokow"));
        }
    }

    public function protectPositionsChoose(BlockBreakEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        $block = $e->getBlock();

        if (isset(ProtectManager::$data[$nick])) {
            $e->cancel(true);
            if (!isset(ProtectManager::$data[$nick][0])) {
                ProtectManager::$data[$nick][0] = $block->getPosition()->asVector3();
                $player->sendMessage("§8» §7Wybierz §92 §7pozycje");
            } elseif (!isset(ProtectManager::$data[$nick][1])) {
                ProtectManager::$data[$nick][1] = $block->getPosition()->asVector3();
                $player->sendMessage("§8» §7Napisz na chacie nazwe terenu");
            }
        }
    }

    /**
     * @param BlockBreakEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function StoniarkaZniszcz(BlockBreakEvent $e)
    {
        $player = $e->getPlayer();
        $level = $player->getWorld();
        $block = $e->getBlock();

        $item = $player->getInventory()->getItemInHand();
        if(isset(UserManager::$blazeRod[$player->getName()])) {
            if($block->getId() !== 1) return;
            Main::getInstance()->getScheduler()->scheduleDelayedTask(new StoniarkaTask($level, $block->getPosition()->asVector3()), 20);
        }



        $x = $e->getBlock()->getPosition()->getFloorX();
        $y = $e->getBlock()->getPosition()->getFloorY();
        $z = $e->getBlock()->getPosition()->getFloorZ();
        $block1 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() - 1, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ()));
        $block2 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() - 2, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ()));

        $block2 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() + 1, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ()));
        $block3 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() + 2, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ()));

        $block4 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() - 1));
        $block5 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() - 2));
        $block6 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() + 1));
        $block7 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() + 2));

        $block8 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() + 1, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() + 1));
        $block9 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() + 1, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() - 1));
        $block10 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() - 1, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() + 1));
        $block11 = $level->getBlock(new Vector3($block->getPosition()->getFloorX() + 1, $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ() + 1));
        $block12 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY() + 1, $block->getPosition()->getFloorZ()));
        $block13 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY() + 2, $block->getPosition()->getFloorZ()));
        $block14 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY() - 1, $block->getPosition()->getFloorZ()));
        $block15 = $level->getBlock(new Vector3($block->getPosition()->getFloorX(), $block->getPosition()->getFloorY() - 2, $block->getPosition()->getFloorZ()));

        if ($item->getId() === \pocketmine\item\ItemIds::GOLDEN_PICKAXE) {
            if($block->getId() !== 1) return;
            $level->dropItem(new Vector3($block->getPosition()->getPosition()->getFloorX(), $block->getPosition()->getFloorY() + 1, $block->getPosition()->getFloorZ()), \pocketmine\item\ItemFactory::getInstance()->get(1));
            $player->sendMessage(Main::format("Pomyslnie zniszczono stoniarke!"));
            return;
        }

        if ($block1->getId() === ItemIds::END_STONE or
            $block2->getId() === ItemIds::END_STONE or
            $block3->getId() === ItemIds::END_STONE or
            $block4->getId() === ItemIds::END_STONE or
            $block5->getId() === ItemIds::END_STONE or
            $block6->getId() === ItemIds::END_STONE or
            $block7->getId() === ItemIds::END_STONE or
            $block8->getId() === ItemIds::END_STONE or
            $block9->getId() === ItemIds::END_STONE or
            $block10->getId() === ItemIds::END_STONE or
            $block11->getId() === ItemIds::END_STONE or
            $block12->getId() === ItemIds::END_STONE or
            $block13->getId() === ItemIds::END_STONE or
            $block14->getId() === ItemIds::END_STONE or
            $block15->getId() === ItemIds::END_STONE) {
            if($block->getId() !== 1) return;

            Main::getInstance()->getScheduler()->scheduleDelayedTask(new StoniarkaTask($level, new Vector3($block->getPosition()->getPosition()->getFloorX(), $block->getPosition()->getFloorY(), $block->getPosition()->getFloorZ())), 40);
            //$level->setBlock(new Vector3($block->getX() + 1, $block->getY(), $block->getZ()), BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::STONE));



        }
    }


    public function onBreak(BlockBreakEvent $e)
    {
        $player = $e->getPlayer();
        $name = $player->getName();
        $block = $e->getBlock();

        if ($block->getId() === ItemIds::DRAGON_EGG && !$e->isCancelled()) {
            switch (mt_rand(0, 2)) { //0 do 2 czyli od 0 case do 2 poniewaz jest 100% szansy ale itemy wypadaja randomowo po 1
                case 0:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BEACON);
                    $itemName = "BEACON";
                    $player->getInventory()->addItem($item);
                    break;

                case 1:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DRAGON_EGG, 0, 32);
                    $itemName = "Pandory x32";
                    $player->getInventory()->addItem($item);
                    break;

                case 2:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(15), 6));
                    $itemName = "6/3/3";
                    $player->getInventory()->addItem($item);
                    break;

                default:
                    $itemName = "BRAK";
            }


            Server::getInstance()->broadcastMessage("§r§8» §7Gracz §9{$name} §7otworzyl meteoryta i zdobyl §9{$itemName}");


        }
    }

    public function stoneDrop(BlockBreakEvent $event): void
    {
        $player = $event->getPlayer();
        $block = $event->getBlock();
        $nick = $player->getName();
        $user = UserManager::getUser($nick)->getDrop();
        $user2 = UserManager::getUser($nick)->getOs();
        $blok = $block;
        $gracz = $player;
        $countIron = PlecakManager::getCountItem($nick, "zelazo");
        $countGold = PlecakManager::getCountItem($nick, "zloto");
        $countDiamond = PlecakManager::getCountItem($nick, "diamenty");
        $countEmerald = PlecakManager::getCountItem($nick, "emeraldy");
        $e = $event;

        //perly TEXT, tnt TEXT, nicie TEXT, szlam TEXT, obsydian TEXT, biblioteczki TEXT, jablka TEXT, wegiel TEXT, cobblestone TEXT
        $countPerly = PlecakManager::getCountItem($nick, "perly");
        $countTnt = PlecakManager::getCountItem($nick, "tnt");
        $countNicie = PlecakManager::getCountItem($nick, "nicie");
        $countSzlam = PlecakManager::getCountItem($nick, "szlam");
        $countObsydian = PlecakManager::getCountItem($nick, "obsydian");
        $countBiblioteczki = PlecakManager::getCountItem($nick, "biblioteczki");
        $countJablka = PlecakManager::getCountItem($nick, "jablka");
        $countWegiel = PlecakManager::getCountItem($nick, "wegiel");
        $countCobblestone = PlecakManager::getCountItem($nick, "cobblestone");

        $x = $blok->getPosition()->getFloorX();
        $y = $blok->getPosition()->getFloorY();
        $z = $blok->getPosition()->getFloorZ();

        $user = UserManager::getUser($nick)->getDrop();
        $pos = $event->getBlock()->getPosition()->asPosition();

        $x = $pos->getFloorX();
        $y = $pos->getFloorY();
        $z = $pos->getFloorZ();

        if ($user->getTime() >= 1) {
            $diamond = round(rand(0, 10000) / 100, 2) < 21.90;
            $gold = round(rand(0, 10000) / 100, 2) < 18.90;
            $eme = round(rand(0, 10000) / 100, 2) < 23.90;
            $zelazo = round(rand(0, 10000) / 100, 2) < 28.90;
            $perly = round(rand(0, 10000) / 100, 2) < 15.90;
            $tnt = round(rand(0, 10000) / 100, 2) < 5.90;
            $nicie = round(rand(0, 10000) / 100, 2) < 13.90;
            $szlam = round(rand(0, 10000) / 100, 2) < 11.90;
            $obsydian = round(rand(0, 10000) / 100, 2) < 20.90;
            $biblioteczki = round(rand(0, 10000) / 100, 2) < 16.90;
            $jablka = round(rand(0, 10000) / 100, 2) < 22.90;
            $coal = round(rand(0, 10000) / 100, 2) < 34.90;
        } else {
            if ($player->hasPermission("NomenHC.drop.gracz")) {
                $diamond = round(rand(0, 10000) / 100, 2) < 11.0;
                $gold = round(rand(0, 10000) / 100, 2) < 8.0;
                $eme = round(rand(0, 10000) / 100, 2) < 13.0;
                $zelazo = round(rand(0, 10000) / 100, 2) < 18.0;
                $perly = round(rand(0, 10000) / 100, 2) < 5.0;
                $tnt = round(rand(0, 10000) / 100, 2) < 2.0;
                $nicie = round(rand(0, 10000) / 100, 2) < 3.0;
                $szlam = round(rand(0, 10000) / 100, 2) < 1.0;
                $obsydian = round(rand(0, 10000) / 100, 2) < 10.0;
                $biblioteczki = round(rand(0, 10000) / 100, 2) < 6.0;
                $jablka = round(rand(0, 10000) / 100, 2) < 12.0;
                $coal = round(rand(0, 10000) / 100, 2) < 24.0;
            } else {
                if ($player->hasPermission("NomenHC.drop.vip")) {
                    $diamond = round(rand(0, 10000) / 100, 2) < 11.30;
                    $gold = round(rand(0, 10000) / 100, 2) < 8.30;
                    $eme = round(rand(0, 10000) / 100, 2) < 13.30;
                    $zelazo = round(rand(0, 10000) / 100, 2) < 18.30;
                    $perly = round(rand(0, 10000) / 100, 2) < 5.30;
                    $tnt = round(rand(0, 10000) / 100, 2) < 2.30;
                    $nicie = round(rand(0, 10000) / 100, 2) < 3.30;
                    $szlam = round(rand(0, 10000) / 100, 2) < 1.30;
                    $obsydian = round(rand(0, 10000) / 100, 2) < 10.30;
                    $biblioteczki = round(rand(0, 10000) / 100, 2) < 6.30;
                    $jablka = round(rand(0, 10000) / 100, 2) < 12.30;
                    $coal = round(rand(0, 10000) / 100, 2) < 24.30;
                } else {
                    if ($player->hasPermission("NomenHC.drop.svip")) {
                        $diamond = round(rand(0, 10000) / 100, 2) < 11.60;
                        $gold = round(rand(0, 10000) / 100, 2) < 8.60;
                        $eme = round(rand(0, 10000) / 100, 2) < 13.60;
                        $zelazo = round(rand(0, 10000) / 100, 2) < 18.60;
                        $perly = round(rand(0, 10000) / 100, 2) < 5.60;
                        $tnt = round(rand(0, 10000) / 100, 2) < 2.60;
                        $nicie = round(rand(0, 10000) / 100, 2) < 3.60;
                        $szlam = round(rand(0, 10000) / 100, 2) < 1.60;
                        $obsydian = round(rand(0, 10000) / 100, 2) < 10.60;
                        $biblioteczki = round(rand(0, 10000) / 100, 2) < 6.60;
                        $jablka = round(rand(0, 10000) / 100, 2) < 12.60;
                        $coal = round(rand(0, 10000) / 100, 2) < 24.60;
                    } else {
                        if ($player->hasPermission("NomenHC.drop.sponsor")) {
                            $diamond = round(rand(0, 10000) / 100, 2) < 11.90;
                            $gold = round(rand(0, 10000) / 100, 2) < 8.90;
                            $eme = round(rand(0, 10000) / 100, 2) < 13.90;
                            $zelazo = round(rand(0, 10000) / 100, 2) < 18.90;
                            $perly = round(rand(0, 10000) / 100, 2) < 5.90;
                            $tnt = round(rand(0, 10000) / 100, 2) < 2.90;
                            $nicie = round(rand(0, 10000) / 100, 2) < 3.90;
                            $szlam = round(rand(0, 10000) / 100, 2) < 1.90;
                            $obsydian = round(rand(0, 10000) / 100, 2) < 10.90;
                            $biblioteczki = round(rand(0, 10000) / 100, 2) < 6.90;
                            $jablka = round(rand(0, 10000) / 100, 2) < 12.90;
                            $coal = round(rand(0, 10000) / 100, 2) < 24.90;
                        } else {
                            $diamond = round(rand(0, 10000) / 100, 2) < 11.0;
                            $gold = round(rand(0, 10000) / 100, 2) < 8.0;
                            $eme = round(rand(0, 10000) / 100, 2) < 13.0;
                            $zelazo = round(rand(0, 10000) / 100, 2) < 18.0;
                            $perly = round(rand(0, 10000) / 100, 2) < 5.0;
                            $tnt = round(rand(0, 10000) / 100, 2) < 2.0;
                            $nicie = round(rand(0, 10000) / 100, 2) < 3.0;
                            $szlam = round(rand(0, 10000) / 100, 2) < 1.0;
                            $obsydian = round(rand(0, 10000) / 100, 2) < 10.0;
                            $biblioteczki = round(rand(0, 10000) / 100, 2) < 6.0;
                            $jablka = round(rand(0, 10000) / 100, 2) < 12.0;
                            $coal = round(rand(0, 10000) / 100, 2) < 24.0;
                        }
                    }
                }
            }
        }


        $cobble = round(rand(0, 10000) / 100, 2) < 100.0;
        $value = PlecakManager::getStatus($player);

        $pickaxes = [270, 274, 257, 278, 285];
        $item = $player->getInventory()->getItemInHand();

        foreach ($pickaxes as $pickaxe) {
            if ($block->getId() === 1 and $event->isCancelled() == false and $item->getId() === $pickaxe) {
                $g_api = $player->getServer()->getPluginManager()->getPlugin("NHC_G");
                if(!$g_api->getGuildManager()->isInOwnPlot($player, $e->getBlock()->getPosition()->asVector3())) {
                    if ($g_api->getGuildManager()->getGuildFromPos($block->getPosition()->getX(), $block->getPosition()->getZ())) return;
                }

             //   $breakStone = $user2->getBreakStone();
                //$user2->setBreakStone($breakStone + 1);
                $player->getXpManager()->addXp(22, true);

                $e->setDrops([\pocketmine\item\ItemFactory::getInstance()->get(0)]);
                $ez = [];

                if ($user->getCobblestone() === "on") {
                    $name = "cobblestone";
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COBBLESTONE, 0, 1);
                    $player->getInventory()->addItem($item);

                }


                if ($tnt) {
                    if ($user->getTnt() === "on") {

                        $ilosc = mt_rand(1, 3);
                        $name = "tnt";
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, $ilosc);

                        // $player->getInventory()->addItem($item);

                        $player->sendTip("§8» §cTNT §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countTnt > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                // return;
                            }
                        }

                    }
                }


                if ($coal) {
                    if ($user->getWegiel() === "on") {

                        $ilosc = mt_rand(1, 4);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::COAL, 0, $ilosc);
                        $name = "wegiel";

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §8Wegiel §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countWegiel > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            }
                        }

                    }
                }

                if ($nicie) {
                    if ($user->getNicie() === "on") {

                        $ilosc = mt_rand(1, 2);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::STRING, 0, $ilosc);
                        $name = "nicie";

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §fNicie §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countNicie > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            }
                        }
                    }
                }

                if ($szlam) {
                    if ($user->getSzlam() === "on") {

                        $ilosc = mt_rand(1, 5);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::SLIME_BALL, 0, $ilosc);
                        $name = "szlam";

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §aSlimeBall §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countSzlam > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            }
                        }

                    }
                }

                if ($obsydian) {
                    if ($user->getObsydian() === "on") {

                        $ilosc = mt_rand(1, 4);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::OBSIDIAN, 0, $ilosc);
                        $name = "obsydian";

                        // $player->getInventory()->addItem($item);

                        $player->sendTip("§8» §5Obsydian §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countObsydian > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            }
                        }

                    }
                }

                if ($biblioteczki) {
                    if ($user->getBiblioteczki() === "on") {

                        $ilosc = mt_rand(1, 4);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOKSHELF, 0, $ilosc);
                        $name = "biblioteczki";

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §6Biblioteczki §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countBiblioteczki > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            }
                        }

                    }
                }

                if ($jablka) {
                    if ($user->getJablka() === "on") {

                        $ilosc = mt_rand(1, 5);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::APPLE, 0, $ilosc);
                        $name = "jablka";

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §cJablko §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countJablka > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                            } else {
                                PlecakManager::addItem($nick, $ilosc, $name);
                                if ($value == "on")
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                // return;
                            }
                        }

                    }
                }

                if ($perly) {
                    if ($user->getPerly() === "on") {

                        $ilosc = mt_rand(1, 3);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENDER_PEARL, 0, $ilosc);
                        $name = "perly";

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §3Perly §8(§7+{$ilosc}§8)");


                        $player->getInventory()->addItem($item);

                    }
                }


                if ($zelazo) {
                    if ($user->getZelazo() === "on") {

                        $ilosc = mt_rand(1, 3);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT, 0, $ilosc);

                        // $player->getInventory()->addItem($item);

                        $player->sendTip("§8» §7Zelazo §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countIron > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, "zelazo");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                //return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, "zelazo");
                                if ($value == "on")
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));

                                return;
                            }
                        }


                    }
                }

                if ($gold) {
                    if ($user->getZloto() === "on") {

                        $ilosc = mt_rand(1, 3);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_INGOT, 0, $ilosc);

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §eZloto §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countGold > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;

                                }
                                PlecakManager::addItem($nick, $ilosc, "zloto");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                            } else {
                                PlecakManager::addItem($nick, $ilosc, "zloto");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                // return;
                            }
                        }


                    }
                }

                if ($diamond) {
                    if ($user->getDiamenty() === "on") {

                        $ilosc = mt_rand(1, 4);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(264, 0, $ilosc);

                        //$player->getInventory()->addItem($item);

                        $player->sendTip("§8» §9Diamenty §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countDiamond > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    return;
                                }
                                PlecakManager::addItem($nick, $ilosc, "diamenty");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                                // return;
                            } else {
                                PlecakManager::addItem($nick, $ilosc, "diamenty");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                    // return;
                                }
                            }
                        }


                    }
                }

                if ($eme) {
                    if ($user->getEmeraldy() === "on") {

                        $ilosc = mt_rand(1, 3);
                        $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD, 0, $ilosc);

                        // $player->getInventory()->addItem($item);

                        $player->sendTip("§8» §aEmeraldy §8(§7+{$ilosc}§8)");

                        if ($player->getInventory()->canAddItem($item)) {
                            $player->getInventory()->addItem($item);
                        } else {
                            if (!$player->hasPermission("NomenHC.plecak.all")) {
                                if ($countEmerald > 1024) {
                                    $player->sendMessage(Main::format("Masz pelny plecak wyplac itemy aby wpadaly one dalej do plecaka"));
                                    //return;
                                }
                                PlecakManager::addItem($nick, $ilosc, "emeraldy");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                            } else {
                                PlecakManager::addItem($nick, $ilosc, "emeraldy");
                                if ($value == "on") {
                                    $player->sendMessage(Main::format("Masz pelny ekwipunek twoje itemy trafily do plecaka §9/plecak"));
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}