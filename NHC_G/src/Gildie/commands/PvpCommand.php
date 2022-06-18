<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender, utils\CommandException};
use Gildie\guild\GuildManager;
use Gildie\Main;
use pocketmine\player\Player;
use pocketmine\item\Item;

class PvpCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("pvp", "Komenda pvp");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;

        $guildManager = Main::getInstance()->getGuildManager();

        $nick = $sender->getName();

        if(!$sender instanceof Player) {
            $sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
            return;
        }


        if(!$guildManager->isInGuild($nick)) {
            $sender->sendMessage(Main::format("Musisz byc w gildii aby uzyc tej komendy!"));
            return;
        }

        $guild = $guildManager->getPlayerGuild($nick);

        if(($guild->getPlayerRank($nick) !== "Leader" && $guild->getPlayerRank($nick) !== "Officer") && !$guildManager->hasPermission($nick, GuildManager::PERMISSION_PVP)) {
            $sender->sendMessage(Main::format("Musisz byc liderem, zastepca gildii albo posiadac permisje aby uzyc tej komendy!"));
            return;
        }

        if(empty($args)) {
            $sender->sendMessage("§8======= [ §l§9PVP §r§8] =======");
            $sender->sendMessage("§l§9/pvp gildia§r§7 - wlacza / wylacza pvp w gildii");
            $sender->sendMessage("§l§9/pvp sojusz§r§7 - wlacza / wylacza pvp sojuszy \n");
            if($guild->isGuildPvP()) { 
                $sender->sendMessage("§7Aktualnie PVP w gildi jest §l§aWLACZONE");
            } else {
                $sender->sendMessage("§7Aktualnie PVP w gildi jest §l§9WYLACZONE");
            }
            
            if($guild->isAlliancesPvP()) { 
                $sender->sendMessage("§7Aktualnie PVP w gildi sojuszy jest §l§aWLACZONE");
            } else {
                $sender->sendMessage("§7Aktualnie PVP w gildi sojuszy jest §l§9WYLACZONE");
            }
            //$sender->sendMessage("$guild->isGuildPvP() ? "PvP w gildii: §8[§l§aON§r§8]" : "PvP w gildii: §8[§l§9OFF§r§8]", $guild->isAlliancesPvP() ? "PvP sojuszy: §8[§l§aON§r§8]" : "PvP sojuszy: §8[§l§9OFF§r§8]"");
           // $sender->sendMessage();
            $sender->sendMessage("§8======= [ §l§9PVP §r§8] =======");
            return;
        }

        switch($args[0]) {

            case "gildia":
                $msg = "";
                if(!$guild->isGuildPvP()) {
                    $guild->setGuildPvP(true);
                    $msg = Main::format("PvP w gildii zostalo §awlaczone");
                } else {
                    $guild->setGuildPvP(false);
                    $msg = Main::format("PvP w gildii zostalo §9wylaczone");
                }

                foreach ($guild->getPlayers() as $nick) {
                    $p = $sender->getServer()->getPlayerExact($nick);

                    if ($p !== null)
                        $p->sendMessage($msg);
                }
            break;

            case "sojusz":
                $msg = "";

                if(!$guild->isAlliancesPvP()) {
                    $guild->setAlliancesPvP(true);
                    $msg = Main::format("PvP sojuszy zostalo §awlaczone");
                } else {
                    $guild->setAlliancesPvP(false);
                    $msg = Main::format("PvP sojuszy zostalo §9wylaczone");
                }

                foreach ($guild->getPlayers() as $nick) {
                    $p = $sender->getServer()->getPlayerExact($nick);

                    if ($p !== null)
                        $p->sendMessage($msg);
                }
                break;
            default:
                $sender->sendMessage(Main::format("Nieznany argument!"));
        }
    }
}