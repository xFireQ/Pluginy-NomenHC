<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\Main;

use Core\user\UserManager;
use pocketmine\entity\Entity;
use pocketmine\Server;
use pocketmine\player\Player;
use pocketmine\entity\projectile\{Egg, Snowball, Arrow};
use pocketmine\event\entity\ProjectileHitEntityEvent;

use pocketmine\network\mcpe\protocol\{GameRulesChangedPacket, LevelSoundEventPacket, LoginPacket, PlayerActionPacket};


use pocketmine\network\mcpe\protocol\{
    AddActorPacket, PlaySoundPacket
};

use pocketmine\level\particle\{
    ExplodeParticle, FlameParticle
};

use pocketmine\block\{
    Block, Stair, Air
};


use pocketmine\event\Listener;



use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use pocketmine\level\{
    Location, Position, Level
};


use pocketmine\event\player\{

    PlayerInteractEvent,
    PlayerQuitEvent,
};

use pocketmine\item\{ItemIds, Tool, Armor, Sword, ChainBoots, DiamondBoots, GoldBoots, IronBoots, LeatherBoots};

use pocketmine\event\entity\EntityDamageEvent;

use pocketmine\event\entity\{
    EntityLevelChangeEvent, EntityDamageByEntityEvent,
    ProjectileLaunchEvent, ProjectileHitEvent,
    EntityTeleportEvent
};

use pocketmine\math\Vector3;


use pocketmine\event\player\{PlayerCreationEvent,
    PlayerMoveEvent,
    PlayerJoinEvent,
    PlayerEvent,
    PlayerPreLoginEvent,
    PlayerRespawnEvent,
    PlayerItemConsumeEvent,
    PlayerExhaustEvent,
    PlayerAnimationEvent,
    PlayerCommandPreprocessEvent,
    PlayerChatEvent,
    PlayerDeathEvent
};

use pocketmine\event\inventory\InventoryPickupItemEvent;

use pocketmine\item\Item;

use pocketmine\event\block\{
    BlockPlaceEvent, BlockBreakEvent
};
use Core\api\CpsAPI;

use pocketmine\event\server\DataPacketReceiveEvent;
use Core\user\SaveInventory;

use Core\managers\PointsManager;
use pocketmine\event\inventory\CraftItemEvent;

use pocketmine\event\inventory\Inventory;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

class EventListener implements Listener {
    use SaveInventory;

    public $coords = array(
        "pos1" => array(
            "x" => -37,
            "z" => 36
        ),

        "pos2" => array(
            "x" => 36,
            "z" => -37
        ),
    );
    public $czas = 31;
    public $gracze = [];
    public $kill;

    public function onPacketReceived(\pocketmine\event\server\DataPacketReceiveEvent $e)
    {
        if ($e->getPacket() instanceof \pocketmine\network\mcpe\protocol\LoginPacket) {
            //Main::setDevice($e->getPacket()->getName(), $e->getPacket()->);

        }
    }

    public function onProjectileHitEntity(ProjectileHitEntityEvent $e)
    {
        $entity = $e->getEntity();
        $entityHit = $e->getEntityHit();

        if ($entityHit instanceof Player) {
            if ($entity instanceof Snowball or $entity instanceof Arrow) {
                if(!$entityHit->isOnline()) return;
                $player = $entity->getOwningEntity();
                $hp = $entityHit->getHealth();
                if($player === null) return;
                if($player->isOnline())
                    $player->sendMessage(Main::format("Gracz §9{$entityHit->getName()}§7 posiada §9{$hp}§3/§920"));
            }
        }
    }

    public function statsOnEat(PlayerItemConsumeEvent $e)
    {
        $player = $e->getPlayer();
        if ($e->isCancelled()) return;

        switch ($e->getItem()->getId()) {
            case 466:
                //$player->removeEffect(new EffectInstance(Effect::getEffect(Effect::ABSORPTION)));
                $player->removeEffect(22);
                break;

            case 322:
                $player->removeEffect(22);
                break;
        }
    }
    public function blockHitsCPS(EntityDamageEvent $e)
    {
        if ($e instanceof EntityDamageByEntityEvent) {
            $damager = $e->getMetar();

            if (!$damager instanceof Player)
                return;

            if (isset(CpsAPI::$blocks[$damager->getName()]))
                $e->cancel(true);
        }
    }

    public function setDefaultCpsData(PlayerJoinEvent $e)
    {
        CpsAPI::setDefaultData($e->getPlayer());
    }

    /*public function clickDetection(DataPacketReceiveEvent $e)
    {
        $packet = $e->getPacket();
        $player = $e->getOrigin()->getPlayer();

        if ($packet instanceof LevelSoundEventPacket) {
            if ($packet->sound == $packet-> || $packet->sound == $packet::SOUND_ATTACK_STRONG) {
                $e->cancel(true);
                CpsAPI::addClick($player);
            }
        }
    }*/

    /**
     * @param EnityDamageEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function setAntyLogout(EntityDamageEvent $e)
    {
        if ($e instanceof EntityDamageByEntityEvent) {
            $entity = $e->getEntity();
            $damager = $e->getMetar();

            if ($entity instanceof Player && $damager instanceof Player) {
                if(isset($this->kill[$damager->getName()])) {
                    unset($this->kill[$damager->getName()]);
                }
                if ($entity->getName() == $damager->getName())
                    return;

                if (!isset(Main::$assists[$entity->getName()]))
                    Main::$assists[$entity->getName()] = [];

                // ASSIST
                if (isset(Main::$lastDamager[$entity->getName()]) && Main::$lastDamager[$entity->getName()]->getName() != $damager->getName()) {
                    if (!in_array(Main::$lastDamager[$entity->getName()]->getName(), Main::$assists[$entity->getName()])) {
                        if (count(Main::$assists[$entity->getName()]) >= 3) {
                            unset(Main::$assists[$entity->getName()][0]);

                            $newArray = [];

                            foreach (Main::$assists[$entity->getName()] as $player)
                                $newArray[] = $player;

                            Main::$assists[$entity->getName()] = $newArray;
                        }

                        Main::$assists[$entity->getName()][] = Main::$lastDamager[$entity->getName()]->getName();
                    }
                }

                // USUWA DAMAGERA Z ASYST JEZELI W NICH JEST
                if (in_array($damager->getName(), Main::$assists[$entity->getName()])) {
                    unset(Main::$assists[$entity->getName()][array_search($damager->getName(), Main::$assists[$entity->getName()])]);
                    $newArray = [];

                    foreach (Main::$assists[$entity->getName()] as $player)
                        $newArray[] = $player;

                    Main::$assists[$entity->getName()] = $newArray;
                }

                Main::$lastDamager[$entity->getName()] = $damager;
                Main::$lastDamager[$damager->getName()] = $entity;

                foreach ([$entity, $damager] as $player)
                    Main::$antylogoutPlayers[$player->getName()] = time();
            }
        }
    }

    public function AntyLogoutBlokadaKomend(PlayerCommandPreprocessEvent $e)
    {
        $player = $e->getPlayer();

        $cmd = explode(" ", $e->getMessage())[0];

        if (isset(Main::$antylogoutPlayers[$player->getName()])) {
            if (in_array($cmd, Main::ANTYLOGOUT_KOMENDY) && !$player->hasPermission("LightPE.antylogout.commands")) {
                $e->cancel(true);
                $player->sendMessage(Main::format("Nie mozesz uzyc tej komendy podczas walki!"));
            }
        }
    }

    public function AntyLogoutQuit(PlayerQuitEvent $e)
    {
        if (isset(Main::$antylogoutPlayers[$e->getPlayer()->getName()]))
            $e->getPlayer()->kill();
    }

    public function AntyLogoutDeath(PlayerDeathEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();


        //$user = UserManager::getUser($nick)->getPoints();

        $e->setDeathMessage("");

        if (isset(Main::$antylogoutPlayers[$nick])) {
            unset(Main::$antylogoutPlayers[$nick]);

            $killer = Main::$lastDamager[$nick];

            if (!$killer->isConnected()) {
                foreach ($player->getArmorInventory()->getContents() as $item)
                    $player->getWorld()->dropItem($player->asVector3(), $item);

                foreach ($player->getInventory()->getContents() as $item)
                    $player->getWorld()->dropItem($player->asVector3(), $item);

                return;
            }

            $e->setKeepInventory(true);

            foreach ($player->getArmorInventory()->getContents() as $item) {
                if ($killer->getInventory()->canAddItem($item))
                    $killer->getInventory()->addItem($item);
                else
                    $killer->getWorld()->dropItem($killer->asVector3(), $item);
            }

            foreach ($player->getInventory()->getContents() as $item) {
                if ($killer->getInventory()->canAddItem($item))
                    $killer->getInventory()->addItem($item);
                else
                    $killer->getWorld()->dropItem($killer->asVector3(), $item);
            }

            $player->getInventory()->clearAll();
            $player->getArmorInventory()->clearAll();

            // $api = Main::getInstance()->getPointsAPI();

            $g_api = $player->getServer()->getPluginManager()->getPlugin("Gildie");
            $user = UserManager::getUser($killer->getName())->getPoints();
            $user2 = UserManager::getUser($nick)->getPoints();

            $pkt_k = $user->getPoints();
            $pkt_d = $user2->getPoints();

            //$pkt = $pkt_d / $pkt_k;

            $assists_pkt = [];

            if (isset(Main::$assists[$nick])) {
                foreach (Main::$assists[$nick] as $assist_nick) {
                    $user3 = UserManager::getUser($assist_nick)->getPoints();
                    if($pkt_d === 0)
                        $pkt_d = 1;
                    $pkt_a = floor(($pkt_d / $user3->getPoints()) * 10);
                    $assists_pkt[$assist_nick] = $pkt_a;
                }
            }

            //$pkt = $pkt_2 / $pkt_1;
            $user = UserManager::getUser($killer->getName())->getPoints();
            $user2 = UserManager::getUser($nick)->getPoints();

            $pkt_1 = $user->getPoints();
            $pkt_2 = $user2->getPoints();

            $pkt = $pkt_2 / $pkt_1;

            $k_pkt = (int)floor($pkt * 45);
            $d_pkt = (int)floor($pkt * 25);

            if ($player->getAddress() == $killer->getAddress()) {
                $k_pkt = 0;
                $d_pkt = 0;
            }

            if($k_pkt >= 125) {
                $k_pkt = 125;
                $d_pkt = 85;
            }

            if($d_pkt >= 125) {
                $k_pkt = 125;
                $d_pkt = 85;
            }

            if (isset(Main::$last[$killer->getName()]) && Main::$last[$killer->getName()] == $player->getName()) {
                $k_pkt = 0;
                $d_pkt = 0;
            }

            $user->setPoints($user->getPoints() + $k_pkt);
            $user2->setPoints($user2->getPoints() - $d_pkt);

            Main::$last[$killer->getName()] = $player->getName();

            $assists_format = "§7z pomoca ";

            foreach ($assists_pkt as $assist_nick => $assist_pkt) {
                $format = "§9{$assist_nick} §8[§6+{$assist_pkt}§8]§7, ";
                if ($g_api != null && $g_api->getGuildManager()->isInGuild($assist_nick)) {
                    $g = $g_api->getGuildManager()->getPlayerGuild($assist_nick);
                    $format = "§8[§9{$g->getTag()}§8] " . $format;
                }
                $assists_format .= $format;
            }

            $assists_format = substr($assists_format, 0, strlen($assists_format) - 2);

            Main::$assists[$nick] = [];

            $killer_format = "§9{$killer->getName()}";
            $death_format = "§9{$nick}";

            if ($g_api != null) {
                if ($g_api->getGuildManager()->isInGuild($killer->getName())) {
                    $g = $g_api->getGuildManager()->getPlayerGuild($killer->getName());
                    $killer_format = "§8[§9{$g->getTag()}§8] " . $killer_format;
                }

                if ($g_api->getGuildManager()->isInGuild($nick)) {
                    $g = $g_api->getGuildManager()->getPlayerGuild($nick);
                    $death_format = "§8[§9{$g->getTag()}§8] " . $death_format;
                }
            }

            foreach (Server::getInstance()->getOnlinePlayers() as $p)  {
                $death = $player;
                /*if($assist_nick !== null)
                PointsManager::addPoints($assist_nick, $assists_pkt);
                return;*/

                $p->sendMessage("§7Gracz §9{$killer_format} §8[§a+{$k_pkt}§8] §7zabija {$death_format} §8[§9-{$d_pkt}§8]" . (count($assists_pkt) == 0 ? "" : " " . $assists_format));
                $killer->sendTitle("§r§l§9ZABOJSTWO", "§r§7{$death->getName()} §8[§a+{$k_pkt}§8]");

                $death->sendTitle("§r§l§9SMIERC", "§r§7{$killer->getName()} §8[§9-{$d_pkt}§8]");
                // $assists->sendTitle("§l§6ASYSTA", "§7{$death->getName()} §8[§6+{$assists_pkt}§8]");
                // Main::getDb()->query("UPDATE stats SET kills = kills + '1' WHERE nick = '$killer->getName()'");
                if($k_pkt === 0) return;
                if(!isset($this->kill[$killer->getName()])) {
                    $killer->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::PRISMARINE_SHARD, 0, mt_rand(1, 3))->setCustomName("§r§l§9ODLAMEK"));
                    $killer->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOB_HEAD, 3, 1)->setCustomName("§r§lGLOWA §9".$death->getName()));
                    $this->kill[$killer->getName()] = true;
                }

            }



        }
    }

    public function craft(CraftItemEvent $event) {
        $player = $event->getPlayer();
        $items = $event->getOutputs();

        foreach($items as $item) {
            if($item->getId() === ItemIds::MOSS_STONE or $item->getId() === \pocketmine\item\ItemIds::DIAMOND_HELMET or $item->getId() === \pocketmine\item\ItemIds::DIAMOND_CHESTPLATE or $item->getId() === \pocketmine\item\ItemIds::DIAMOND_LEGGINGS or $item->getId() === \pocketmine\item\ItemIds::DIAMOND_BOOTS or $item->getId() === \pocketmine\item\ItemIds::DIAMOND_SWORD) {
                $event->cancel(true);
                $player->sendMessage(Main::format("Craftowanie diamentowych itemow jest wylaczone!"));
            }
        }


    }

    /*public function LightningStrikeOnDeath(PlayerDeathEvent $e)
    {

        $death = $e->getPlayer();
        $player = $e->getPlayer();
        $pk = new AddActorPacket();
        $pk->type = "minecraft:lightning_bolt";
        $pk->entityRuntimeId = Entity::$entityCount++;
        $pk->position = $player->asVector3();

        $death->getServer()->broadcastPacket($death->getWorld()->getPlayers(), $pk);

        $pk = new PlaySoundPacket();
        $pk->soundName = "ambient.weather.lightning.impact";
        $pk->x = $death->getX();
        $pk->y = $death->getY();
        $pk->z = $death->getZ();
        $pk->volume = 500;
        $pk->pitch = 1;

        $death->getServer()->broadcastPacket($death->getWorld()->getPlayers(), $pk);
        $death->teleport($death->getWorld()->getSafeSpawn());

    }*/

}