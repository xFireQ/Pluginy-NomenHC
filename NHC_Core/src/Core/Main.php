<?php

namespace Core;

use Core\managers\ProtectManager;
use Core\task\MeteoriteTask;
use Core\warps\WarpsManager;
use MongoDB\Driver\Server;
use Core\task\WhiteListTask;
use pocketmine\crafting\ShapedRecipe;
use pocketmine\data\bedrock\EnchantmentIdMap;
use pocketmine\data\bedrock\EnchantmentIds;
use pocketmine\entity\Human;
use pocketmine\item\enchantment\ItemFlags;
use pocketmine\item\enchantment\Rarity;
use pocketmine\item\enchantment\StringToEnchantmentParser;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\ItemFactory;
use pocketmine\lang\KnownTranslationFactory;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\Config;
use Core\enchantments\Knockback;
use Core\guild\GuildManager;
use Core\task\NameTagsTask;
use Core\utils\ShapesUtils;
use pocketmine\item\enchantment\Enchantment;
use Core\fakeinventory\FakeInventoryAPI;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;

use pocketmine\block\Block;
use pocketmine\utils\RegistryTrait;
use pocketmine\tile\{
    Tile, Chest as TileChest, Sign as TileSign
};

use Core\task\NameTagTask;
use Core\task\BanTask;
use Core\task\MuteTask;
use Core\task\ClearLagTask;
use Core\task\AlwaysDayTask;
use Core\task\BotTask;
use Core\task\AntyLogoutTask;
use Core\task\KitsTask;
use Core\utils\Utils;
use Core\utils\ConfigUtil;
use pocketmine\player\Player;
use pocketmine\utils\TextFormat;
use pocketmine\entity\Creature;
use Core\entity\EntityManager;
use Core\settings\SettingsManager;
use Core\drop\DropManager;
use Core\command\CommandManager;
use Core\listener\ListenerManager;
use Core\api\LobbyAPI;

use Core\group\GroupManager;
use Core\provider\{
    Provider, SQLite3Provider
};
use Core\user\UserManager;
use Core\item\ItemManager;
use Core\Block\BlockManager;
use Core\managers\PointsManager;
use Core\managers\HomeManager;
use Core\managers\PlecakManager;
use Core\managers\DepositManager;
use Core\managers\IsManager;
use Core\managers\SchowekManager;
use Core\managers\SklepManager;
use Core\managers\BackupManager;
use Core\managers\Kit;
use Core\managers\OsManager;
use Core\api\BanAPI;
use Core\api\MuteAPI;
use Core\task\StoniarkaTask;
use Core\modules\FastBreak;
use Core\modules\Reach;
use Core\modules\Noclip;
use Core\modules\SpeedHack;
use Core\user\SaveInventory;
use Core\fakeinventory\FakeInventoryManager;
use Core\managers\SkinManager;
use Core\wings\WingsManager;
use Core\user\User;

class Main extends PluginBase {
    private static $instance;
    private $kitsAPI;
    private $enderCfg;
    private $banAPI;
    private $muteAPI;

    private $guildManager;
    private $skarbiecConfig;

    public static $invite = [];
    public static $alliance = [];
    public static $bazaTask = [];
    public static $warps = [];

    public static \SQLite3 $db;
    public static $chatOn = false;
    public static $tp = [];
    public static $tpTask = [];
    public const VERSION = '1.0';
    public static $antylogoutPlayers = [];
    public static $turboPlayers = [];
    public static $lastDamager;
    public static $assists = [];
    public static $last;
    public static $homeTask = [];
    public $enderchest;

    private $groupManager;
    private $settings;
    public static $lastCmd = [];
    public static $spawnTask;
    private $provider;
    public static $god = [];
    public static $lastChatMsg = [];
    public static $spr = [];
    public static $msgR = [];
    public static $opcjeOn = false;

    public const CPS_MAX = 13;
    public const CPS_COOLDOWN = 4;


    public const ANTYLOGOUT_TIME = 30;
    public const BREAK_TIME = 7;
    public const TURBODROP_TIME = 50;
    public const ANTYLOGOUT_KOMENDY = ["/tpa", "/tpaccept", "/tpdeny", "/dolacz", "/home",
        "/spawn", "/schowek", "/kit", "/ec", "/schowek", "/ustawbaze", "/lider", "baza",
        "/warp", "/sojusz", "/permisje", "/oficer", "/repair", "/repair-all", "/heal", "/feed"];

    public static $name = "Core";
    //PLUGIN VERSION
    public static $version = "1.0.0"; //IT IS IN STRING TO SHOW THE EXACT VERSION
    //AUTHOR
    public static $author = "fireq";
    public static $whitelist;
    public static $playersOs;
    private $configg;
    private static $device = [];
    public static array $lobbyPos = [
        "x" => 0,
        "y" => -5,
        "z" => 0];

    private FakeInventoryManager $fakeInventoryManager;

    public static function setDevice(string $name, int $device) : void {
        self::$device[$name] = $device;
    }

    public static function getDevice(string $name) : ?int {
        if(isset(self::$device[$name]))
            return self::$device[$name];

        return null;
    }

    public function onLoad() : void {
        $inventories_dir = $this->getDataFolder() . "inventories";
        if(!is_dir($inventories_dir)) {
            mkdir($inventories_dir);
        }
    }



    public function onEnable() : void {
        self::$instance = $this;
        @mkdir($this->getDataFolder() . "wings");
        @mkdir($this->getDataFolder() . "playersSkins");
        @mkdir($this->getDataFolder() . "players");

        // User::$lobbyTask["elo"] = Main::getInstance()->getScheduler()->scheduleRepeatingTask(new WhiteListTask(), 20);
        MeteoriteTask::$hp = 100;

        SkinManager::init($this);
        WingsManager::init($this);

        $this->registerCrafting();
        //REGISTER ENCHNT FORTUNE1111111111111111111111111

        @mkdir($this->getDataFolder());
        $this->saveDefaultConfig();

        $this->kitsAPI = new Kit;

        date_default_timezone_set('Europe/Warsaw');

        self::$db = new \SQLite3($this->getDataFolder()."DataBase.db");
        Main::getInstance()->getDb()->exec("CREATE TABLE IF NOT EXISTS kits (nick TEXT, kit TEXT, date TEXT)");
        Main::getInstance()->getDb()->exec("CREATE TABLE IF NOT EXISTS 'cp' (count INT)");
        Main::getInstance()->getDb()->exec("CREATE TABLE IF NOT EXISTS ban (nick TEXT, reason TEXT, date TEXT, ip TEXT, adminNick TEXT)");
        Main::getInstance()->getDb()->exec("CREATE TABLE IF NOT EXISTS mute (nick TEXT, reason TEXT, date TEXT, adminNick TEXT)");
        Main::getInstance()->getDb()->exec("CREATE TABLE IF NOT EXISTS stats (nick TEXT, kills INT, deaths INT, koxy INT, refy INT, perly INT, kroki INT, break INT)");
        Main::getInstance()->getDb()->exec("CREATE TABLE IF NOT EXISTS stoniarki (x INT, y INT, z INT, time DOUBLE)");


        $this->saveResource("config.yml", true);

        $this->saveResource("configCraftingi.yml", true);
        //WHITELIST PLUGIN
        /*$this->saveResource("whitelist.yml");
        self::$whitelist = new Config($this->getDataFolder()."whitelist.yml", Config::YAML, [
            "Status" => false,
            "NickPlayers" => [],
            "Format" => "WhiteList",
            "KickMessage" => "&c&lWhiteLista jest aktualnie WLACZONA!",
            "date" => 0
        ]);*/

        //CraftingManager::init(new Config($this->getDataFolder() . "configCraftingi.yml", Config::YAML));

        CommandManager::init();
        LobbyAPI::init();
        BlockManager::init();
        DropManager::init();
        PointsManager::init();
        SettingsManager::init();
        UserManager::init();
        DepositManager::init();
        UserManager::loadUsers();
        ListenerManager::init();
        UserManager::init();
        IsManager::init();
        PlecakManager::init();
        HomeManager::init();
        SklepManager::init();
        EntityManager::init();
        OsManager::init();
        ItemManager::init();
        ProtectManager::init();

        $this->banAPI = new BanAPI;
        $this->muteAPI = new MuteAPI;
        $this->getLogger()->info(TextFormat::DARK_GREEN . "Wlaczony!");


        $botCfg = new Config($this->getDataFolder(). "BotMessages.yml", Config::YAML, ["messages" => ["Wszystkie dostepne komendy znajdziesz pod §9/pomoc", "Rangi oraz inne uslugi mozesz zakupic na naszej stronie §9www.NomenHC.PL", "Dolacz na naszego discorda: §9https://discord.gg/78ztv8PNDV"]]);


        $this->config = new Config($this->getDataFolder(). "Config.yml", Config::YAML, [
            "hits" => "4.0",
            "motto" => "§8[§l§9Nomen§fHC§r§8]",
            "sprawdzanie" => [
                "x" => 0,
                "y" => 80,
                "z" => 0
            ],
            "startedycji" => false,
            "stime" => "00:00"
        ]);

        $this->saveResource("configg.yml");
        $this->configg = new Config($this->getDataFolder(). "configg.yml", Config::YAML);

        //WHITELIST PLUGIN
        $this->saveResource("whitelist.yml");
        self::$whitelist = new Config($this->getDataFolder()."whitelist.yml", Config::YAML, [
            "Status" => false,
            "NickPlayers" => [],
            "Format" => "WhiteList",
            "KickMessage" => "&c&lWhiteLista jest aktualnie WLACZONA!"
        ]);

        $this->saveResource("warps.yml");
        self::$warps = new Config($this->getDataFolder()."whitelist.yml", Config::YAML, [
            "Warps" => [],
            "X" => "0",
            "Y" => "100",
            "Z" => "0"
        ]);


        $this->getServer()->getNetwork()->setName($this->config->get("motto"));
        $this->getScheduler()->scheduleRepeatingTask(new BotTask($botCfg), 20*50);
        $this->getScheduler()->scheduleDelayedRepeatingTask(new KitsTask, 20, 20);
        $this->getScheduler()->scheduleRepeatingTask(new AntyLogoutTask($botCfg), 20);
        $this->getScheduler()->scheduleRepeatingTask(new ClearLagTask(30), 20);
        $this->getScheduler()->scheduleDelayedRepeatingTask(new BanTask, 20, 20);
        $this->getScheduler()->scheduleDelayedRepeatingTask(new MuteTask, 20, 20);
        $this->getScheduler()->scheduleRepeatingTask(new AlwaysDayTask($this), 1200 * 5);

        WarpsManager::init();

        $this->saveResource("settings.yml");

        $this->settings = $settings = new Config($this->getDataFolder(). 'settings.yml', Config::YAML);
        $provider = null;

        switch(strtolower($settings->get("provider"))) {
            case "sqlite3":
                $provider = new SQLite3Provider();
                break;

            case "mysql":
                //TODO
                break;

            default:
                $provider = new SQLite3Provider();
        }

        $this->provider = $provider;

        $this->groupManager = new GroupManager($provider);

        $this->registerEnchantments();

        $this->getServer()->getPluginManager()->registerEvents(new FastBreak($this), $this);
        // $this->getServer()->getPluginManager()->registerEvents(new SpeedHack($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Reach($this), $this);
        $this->getServer()->getPluginManager()->registerEvents(new Noclip($this), $this);
        $this->fakeInventoryManager = new FakeInventoryManager();



    }

    public function getFakeInventoryManager() : FakeInventoryManager {
        return $this->fakeInventoryManager;
    }

    public function registerEnchantments()
    {
        $i = 0;

        //   self::_registryRegister("KNOCKBACK", new Knockback(KnownTranslationFactory::enchantment_knockback(), Rarity::UNCOMMON, ItemFlags::SWORD, ItemFlags::NONE, 2));

        $i++;

        $this->getLogger()->info(TextFormat::DARK_GREEN . "Zaladowano (" . $i . ") enchant pomyslnie.");
    }

    public function onDisable() : void {
        UserManager::saveUsers();
        IsManager::saveServices();
        PlecakManager::saveUsersDrop();
        //self::$whitelist->save();

        foreach(UserManager::getUsers() as $user) {
            $user->saveDeposit();
            $user->savePoints();
            $user->saveDrop();
        }


    }

    public static function getDb() : \SQLite3{
        return self::$db;
    }

    public function getBanAPI() : BanAPI {
        return $this->banAPI;
    }

    public function getMuteAPI() : MuteAPI {
        return $this->muteAPI;
    }

    public function getKitsAPI() : Kit {
        return $this->kitsAPI;
    }

    public static function getErrorMessage() : string {
        return "§r§8[§l§9Nomen§fHC§r§8] §7Wystapil blad w komendzie§8!§r";;
    }

    public static function getPermissionMessage() : string {
        return "§r§8[§l§9Nomen§fHC§r§8] §7Nie posiadasz permisji aby uzyc tej komendy!§r";
    }

    public function registerTasks()
    {
        $i = 0;

        $task = new BotTask($this);
        $this->getScheduler()->scheduleDelayedRepeatingTask($task, 20 * 1, 20 * 1);

        $this->getLogger()->info("Zaladowano (" . $i . ") taskow pomyslnie.");
    }

    public static function getInstance() : Main {
        return self::$instance;
    }



    public function getGuildManager() : GuildManager {
        return $this->guildManager;
    }



    public function getGroupManager() : GroupManager {
        return $this->groupManager;
    }

    public function getSettings() : Config {
        return $this->settings;
    }

    public function getPoints(string $nick) {
        if(UserManager::getUser($nick) === null) return null;
        return UserManager::getUser($nick)->getPoints()->getPoints();
    }

    public function getProvider() : Provider {
        return $this->provider;
    }


    public static function format($w){


        return "§r§8[§9Nomen§fHC§8]§r §7{$w}§r";

    }

    public function clearlag() : void {
        $count = 0;
        $countChunk = 0;

        foreach($this->getServer()->getWorldManager()->getWorlds() as $level) {
            foreach($level->getEntities() as $entity) {
                if(!$entity instanceof Creature) {
                    if(!$entity instanceof Human) {
                        $entity->close();

                        $count++;
                    }

                }
            }
        }

        foreach($this->getServer()->getOnlinePlayers() as $p) {
            $p->sendMessage(self::format("Pomyslnie usunieto §9$count §7itemow ze swiata§9!"));

        }


    }

    public function reload() : void {
        $this->settings = $settings = new Config($this->getDataFolder(). 'settings.yml', Config::YAML);

        $this->groupManager->reload();
    }

    
    private function registerCrafting() : void {
        $kox_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(41), "J" => ItemFactory::getInstance()->get(260)], [ItemFactory::getInstance()->get(466)]);
        $boyfarmer_item = \pocketmine\item\ItemFactory::getInstance()->get(49);
        $boyfarmer_item->setCustomName("§r§6BoyFarmer");
        $boyfarmer_item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
        $boyfarmer_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(49), "J" => \pocketmine\item\ItemFactory::getInstance()->get(264)], [$boyfarmer_item]);

        $kopaczfosy_item = \pocketmine\item\ItemFactory::getInstance()->get(1);
        $kopaczfosy_item->setCustomName("§r§6KopaczFosy");
        $kopaczfosy_item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
        $kopaczfosy_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(1), "J" => \pocketmine\item\ItemFactory::getInstance()->get(264)], [$kopaczfosy_item]);

        $enderchest_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(49), "J" => \pocketmine\item\ItemFactory::getInstance()->get(368)], [\pocketmine\item\ItemFactory::getInstance()->get(130)]);

        $rzucak_item = \pocketmine\item\ItemFactory::getInstance()->get(52);
        $rzucak_item->setCustomName("§r§l§cRzucak");
        $rzucak_item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
        $rzucak_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(46, 0, 64), "J" => \pocketmine\item\ItemFactory::getInstance()->get(46)], [$rzucak_item]);

        $stoniarka05 = \pocketmine\item\ItemFactory::getInstance()->get(121);
        $stoniarka05->setCustomName("§r§3Stoniarka§9 1s");
        $stoniarka05->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
        $stoniarka05_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(4), "J" => \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND)], [$stoniarka05]);

        $stoniarka15 = \pocketmine\item\ItemFactory::getInstance()->get(121);
        $stoniarka15->setCustomName("§r§3Stoniarka§9 2s");
        $stoniarka15->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
        $stoniarka15_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(4), "J" => \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD)], [$stoniarka15]);

        $stoniarka3 = \pocketmine\item\ItemFactory::getInstance()->get(121);
        $stoniarka3->setCustomName("§r§3Stoniarka§9 3s");
        $stoniarka3->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));
        $stoniarka3_recipe = new ShapedRecipe(["GGG", "GJG", "GGG"], ["G" => \pocketmine\item\ItemFactory::getInstance()->get(4), "J" => \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_INGOT)], [$stoniarka3]);

        $this->getServer()->getCraftingManager()->registerShapedRecipe($stoniarka3_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($stoniarka05_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($stoniarka15_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($kox_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($boyfarmer_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($kopaczfosy_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($enderchest_recipe);
        $this->getServer()->getCraftingManager()->registerShapedRecipe($rzucak_recipe);
    }

    public function getPluginConfig(): Config {
        return $this->configg;
    }

}