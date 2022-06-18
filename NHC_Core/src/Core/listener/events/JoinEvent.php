<?php

namespace Core\listener\events;

use Core\bossbar\BossbarManager;
use Core\format\Permission;
use Core\task\TurbodropTask;
use Core\user\User;
use pocketmine\command\defaults\DefaultGamemodeCommand;
use pocketmine\player\GameMode;
use pocketmine\player\Player;

use pocketmine\event\Listener;
use Core\user\UserManager;

use Core\managers\BackupManager;

use Core\managers\NameTagManager;
use pocketmine\Server;

use Core\Main;
use Core\api\LobbyAPI;
use Core\user\SaveInventory;

use Core\settings\SettingsManager;
use Core\drop\DropManager;
use Core\managers\PointsManager;
use Core\managers\SchowekManager;
use Core\managers\PlecakManager;
use Core\managers\SklepManager;
use Core\managers\IsManager;
use Core\bossbar\BossBar;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\{
    AddActorPacket, PlaySoundPacket
};
use pocketmine\network\mcpe\protocol\{GameRulesChangedPacket,
    LevelSoundEventPacket,
    LoginPacket,
    PlayerActionPacket,
    types\BoolGameRule};

use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerQuitEvent;

use pocketmine\event\player\PlayerPreLoginEvent;
use Core\wings\WingsManager;
use Core\managers\SkinManager;
use Core\util\SkinUtil;
use Core\wings\Wings;
use pocketmine\entity\Skin;
use pocketmine\math\Vector3;
use pocketmine\level\Level;
use pocketmine\utils\Config;

class JoinEvent implements Listener {
    use SaveInventory;

    public function onJoin(PlayerJoinEvent $event) : void {
        $player = $event->getPlayer();
        $skin = $player->getSkin();
        $nick = $player->getName();
        $name = $player->getName();

        if(Permission::isOp($player))
            if(!isset(UserManager::$ac[$player->getName()]))
                UserManager::$ac[$player->getName()] = true;

        if(!$player->hasPlayedBefore()) {
            $x = mt_rand(-550, 550);
            $z = mt_rand(-550, 550);
            if(Server::getInstance()->getWorldManager()->getDefaultWorld()->isChunkLoaded($x, $z)) {
                $y = $event->getPlayer()->getWorld()->getHighestBlockAt($x, $z) + 1;
                $event->getPlayer()->teleport(new Vector3($x, $y, $z));
            } else {
                //$player->teleport(Server::getInstance()->getWorldManager()->getDefaultWorld()->getSafeSpawn());
            }

        }
        //rmdir("players/" . $player->getName().".yml");
        /* if(is_dir(Main::getInstance()->getDataFolder() . "players/" . $player->getName().".yml")) {
             unlink(Main::getInstance()->getDataFolder() . "players/" . $player->getName().".yml");
             var_dump("EEEE");
         }*/
        $path = Main::getInstance()->getDataFolder() . "players/" . $player->getName().".yml";
        $config2 = new Config($path);

        $config2->set("IP", $player->getNetworkSession()->getIp());
        $config2->set("XUID", $player->getXuid());
        $config2->set("UUID", $player->getUniqueId()->toString());
        $config2->set("Nazwa", $player->getDisplayName());
        $config2->set("Port", $player->getNetworkSession()->getPort());
        $config2->set("Ping", $player->getNetworkSession()->getPing());
        $device = "BRAK ";
        if (Main::getDevice($name) == 7) {
            $device = "Windows 10";
        } elseif (Main::getDevice($name) == 1) {
            $device = "Android";
        } elseif (Main::getDevice($name) == 2) {
            $device = "iOS";
        } else {
            $device = "KONSOLA";
        }
        $config2->set("Urzadzenie", $device);

        $config2->set("count", 0);
        $config2->save();

        if(!UserManager::userExists($player->getName()))
            UserManager::createUser($player);

        if(UserManager::userExists($nick)) {
            if(UserManager::getUser($nick)->getDrop()->getTime() >= 1) {
                User::$tdTask[$nick] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new TurbodropTask($player, UserManager::getUser($nick)->getDrop()->getTime()), 20);

            }
        }


        if($player->getGamemode() == GameMode::ADVENTURE()) $player->setGamemode(GameMode::SURVIVAL());

        $newSkin = new Skin($skin->getSkinId(), SkinUtil::skinImageToBytes(SkinManager::getPlayerSkinImage($player->getName())), "", SkinManager::getDefaultGeometryName(), SkinManager::getDefaultGeometryData());

        $wings = WingsManager::getPlayerWings($player->getName());

        if($wings !== null)
            WingsManager::setWings($player, $wings);
        else {
            $player->setSkin($newSkin);
            $player->sendSkin();
        }

        SkinManager::setPlayerSkin($player, $newSkin);
    }

    public function getOSAsString(Player $player)
    {
        return "KONSOLA";
        /*if ($player->get() == 7) {
            return "Windows 10";
        } elseif ($player->getDeviceOS() == 1) {
            return "Android";
        } elseif ($player->getDeviceOS() == 2) {
            return "iOS";
        } else {
            return "KONSOLA";
        }*/
    }

    public function QuitMessage(PlayerQuitEvent $e)
    {
        $e->setQuitMessage("");
    }

    public function BanKick(PlayerJoinEvent $e): void
    {
        $player = $e->getPlayer();
        $api = Main::getInstance()->getBanAPI();

        if ($api->isBanned($player->getName()) || $api->isIpBanned($player->getNetworkSession()->getIp())) {
            $player->kick(" ", $api->getBanMessage($player));
        }
    }

    public function settingsJoin(PlayerJoinEvent $e) {
        $player = $e->getPlayer();
        $nick = $player->getName();

        SettingsManager::setDefault($player);
        PlecakManager::setDefault($player);

        if (empty(Main::getInstance()->getDb()->query("SELECT * FROM 'sklep' WHERE nick = '$nick'")->fetchArray())){
            SklepManager::setDefault($player);

            Main::getInstance()->getDb()->query("UPDATE 'cp' SET count = count + '1'");
        }
    }

    /**
     * @param PlayerJoinEvent $e
     * @priority LOWEST
     * @ignoreCancelled true
     */
    public function onJoinRegisterPlayer(PlayerJoinEvent $e) : void{
        $e->setJoinMessage(" ");
        $player = $e->getPlayer();
        $array = Main::getInstance()->getDb()->query("SELECT * FROM 'cp'")->fetchArray(SQLITE3_ASSOC);
        $countP = 0;
        if(empty($array["count"])) {
            $countP = 0;
        } else {
            $countP = $array ?? ["count"];
        }
        $player->sendMessage("§r§8=========[ §9Nomen§fHC §8]==========");
        $player->sendMessage("§r§8» §7Witaj na serwerze §9Nomen§fHC.PL");
        $player->sendMessage("§r§8» §7Aktualnie gra §9".count(Server::getInstance()->getOnlinePlayers()) . "§r§7 graczy!");
        $player->sendMessage("§r§8» §7Nasza strona www: §9www.NomenHC.PL");
        $player->sendMessage("§r§8» §7Nasz discord: §9https://discord.gg/QcAwajM2C9");
        $player->sendMessage("§r§8=========[ §9Nomen§fHC §8]==========");

    }

    public function permissionsOnJoin(PlayerJoinEvent $e) {
        $player = $e->getPlayer();
        $groupManager = Main::getInstance()->getGroupManager();
        $groupManager->registerPlayer($player);

        if(!$groupManager->getPlayer($player->getName())->hasGroup()) {
            if($groupManager->getDefaultGroup() == null) {
                $player->sendMessage(Main::format("Default group not found!"));
                return;
            }
            $groupManager->getPlayer($player->getName())->addDefaultGroup();
        }
    }

    public function updateNametag(PlayerJoinEvent $e) {
        NameTagManager::updateNameTag($e->getPlayer());
    }

    public function StatsOnJoin(PlayerJoinEvent $e)
    {
        $nick = $e->getPlayer()->getName();

        $db = Main::getInstance()->getDb();
        UserManager::topPoinst();


        if (empty($db->query("SELECT * FROM 'stats' WHERE nick = '$nick'")->fetchArray()))
            $db->query("INSERT INTO 'stats' (nick, kills, deaths, koxy, refy, perly, kroki, break) VALUES ('$nick', '0', '0', '0', '0', '0', '0', '0')");
    }

  /*  public function cordsOnJoin(PlayerJoinEvent $e) : void{
        $player = $e->getPlayer();

        $pk = new GameRulesChangedPacket();
        $pk->gameRules = ["showcoordinates" => new BoolGameRule(true, true);

        $player->getNetworkSession()->sendDataPacket($pk);
    }*/
}