<?php

namespace Core\command;

use Core\command\commands\admin\UnbanIpCommand;
use Core\command\default\GamemodeCommand;
use Core\command\default\ProtectCommand;
use Core\command\default\VersionCommand;
use Core\command\commands\player\WarpCommand;
use Core\command\commands\admin\WhitelistCommand;
use Core\command\commands\admin\VanishCommand;
use pocketmine\Server;
use pocketmine\utils\Config;
use pocketmine\utils\TextFormat;

use Core\command\commands\admin\{AntyCheatCommand,
    APointsCommand,
    ChatCommand,
    DeviceCommand,
    HitsCommand,
    LobbyCommand,
    AlertCommand,
    TempbanCommand,
    UserInfoCommand,
    UslugaCommand,
    PexCommand,
    VoucherCommand,
    PcaseCommand,
    ClearlagCommand,
    ClearCommand,
    FlyCommand,
    GodCommand,
    BanCommand,
    HealCommand,
    SprawdzanieCommand,
    UnbanCommand,
    MuteCommand,
    MeteoriteCommand,
    UnmuteCommand,
    SizeCommand,
    KickCommand,
    TurbodropCommand,
    PremiumCommand,
    BackupCommand,
    BossCommand,
    SkrzydlaCommand,
    BanIpCommand,
    XpCommand};

use Core\command\commands\player\{BlocksCommand,
    CobblexCommand,
    HelpCommand,
    PingCommand,
    QuestCommand,
    TpacceptCommand,
    TpaCommand,
    TpdenyCommand,
    DropCommand,
    TradeCommand,
    YtCommand,
    YtpCommand,
    HomeCommand,
    SklepCommand,
    FeedCommand,
    SethomeCommand,
    DelhomeCommand,
    HelpopCommand,
    SchowekCommand,
    PlecakCommand,
    AdministracjaCommand,
    ListCommand,
    EffectCommand,
    MsgCommand,
    PrzyznajesieCommand,
    RCommand,
    RepairCommand,
    SpawnCommand,
    CraftingiCommand,
    KitCommand,
    IsCommand,
    OsCommand,
    TopCommand};
use Core\command\default\PluginsCommand;

class CommandManager {
	
	public static function init() {
	    
	    $unregisterCommands = [
            "list",
            "ban",
            "ban-ip",
            "pardon",
            "pardon-ip",
            "list",
            "msg",
            "help",
            "me",
            "banlist",
            "defaultgamemode",
            "dumpmemory",
            "effect",
            "kick",
            "tell",
            "kill",
            "checkperm",
            "suicide",
            "about",
            "version",
            "help",
            "?",
            "gc",
            "clear",
            "gamemode",
            "plugins",
            "whitelist"
        ];

        foreach($unregisterCommands as $commandName) {
            $command = Server::getInstance()->getCommandMap()->getCommand($commandName);

            if($command === null)
                continue;

            Server::getInstance()->getCommandMap()->unregister($command);
            
            
        }
        Server::getInstance()->getLogger()->info(TextFormat::DARK_GREEN . "Odrejestrowano wszystkie zapisane komendy pomsylnie");

        $cmd = [
            new TempbanCommand(),
            new UnbanIpCommand(),
            new APointsCommand(),
            new ClearCommand(),
            new FeedCommand(),
            new FlyCommand(),
            new HitsCommand(),
             new CraftingiCommand(),
            new GodCommand(),
            new HealCommand(),
            new SklepCommand(),
            new TurbodropCommand(),
            new ListCommand(),
            new UslugaCommand(),
            new MeteoriteCommand(),
            new AdministracjaCommand(),
            new MsgCommand(),
            new PrzyznajesieCommand(),
            new RCommand(),
            new LobbyCommand(),
            new RepairCommand(),
            new OsCommand(),
            new SprawdzanieCommand(),
            new HelpCommand(),
            new SizeCommand(),
            //new SettingsCommand(),
            new BackupCommand(),
            new ChatCommand(),
            new DropCommand(),
            new PlecakCommand(),
            new KickCommand(),
            new YtCommand(),
            new PexCommand(),
            new PremiumCommand(),
            new AlertCommand(),
            new SchowekCommand(),
            new EffectCommand(),
            new YtpCommand(),
            new SpawnCommand(),
            new ClearlagCommand(),
            // new ZalozCommand(),
            //new InfoCommand(),
            new HelpopCommand(),
            new PcaseCommand(),
            new BanCommand(),
            new PingCommand(),
            new MuteCommand(),
            new UnbanCommand(),
            new UnmuteCommand(),
            new VoucherCommand(),
            new HomeCommand(),
            new DelhomeCommand(),
            new SethomeCommand(),
            new IsCommand(),
            new KitCommand(),
            new BanIpCommand(),
            new BossCommand(),
            new QuestCommand(),
            new CobblexCommand(),
            new TopCommand(),
            new TpaCommand(),
            new TpdenyCommand(),
            new TpacceptCommand(),
            new XpCommand(),
            new WhitelistCommand(),
            new GamemodeCommand(),
            new VersionCommand(),
            new PluginsCommand(),
            new SkrzydlaCommand(),
            new ProtectCommand(),
            new WarpCommand(),
            new TradeCommand(),
            new DeviceCommand(),
            new VanishCommand(),
            new WhitelistCommand(),
            new UserInfoCommand(),
            new BlocksCommand(),
            new AntyCheatCommand()
        ];
		
		Server::getInstance()->getCommandMap()->registerAll("core", $cmd);
		Server::getInstance()->getLogger()->info(TextFormat::DARK_GREEN . "Zaladowano wszystkie komendy pomyslnie.");
	}
	
	
}