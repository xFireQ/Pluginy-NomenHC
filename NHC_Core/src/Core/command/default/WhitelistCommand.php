<?php

namespace Core\command\default;

use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Core\util\ConfigUtil;
use Core\Main;

class WhitelistCommand extends Command {
    public function __construct() {
        parent::__construct("whitelist", "komenda whitelist", true, ["wl"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {
        $player = $sender;
        if(!$player->isOp() or !$player->hasPermission("Core.commands.admin")) {
            $sender->sendMessage(ConfigUtil::getMessage("messages.permissions", false));
            return true;
        }

        if(empty($args)) {
            $messages = ConfigUtil::getMessage("commands.whitelist.empty");
            foreach ($messages as $message) {
                $sender->sendMessage($message);
            }
            return true;
        }

        if (isset($args)) {
            if($args[0] == "format") {
                if(isset($args[1])) {
                    $newformat = "";
                    for ($i = 1; $i <= count($args) - 1; $i++)
                        $newformat .= $args[$i] . " ";

                    Main::$whitelist->set("KickMessage", "&r" . $newformat);
                    Main::$whitelist->save();
                    $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.format.ok"));
                } else {
                    $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.format.usage"));
                }
            }

            if($args[0] == "status") {
                $status = Main::$whitelist->get("Status");
                if($status == true) {
                    $status = "WLACZONA";
                } else {
                    $status = "WYLACZONA";
                }
                $sender->sendMessage(str_replace("{STATUS}", $status, ConfigUtil::getMessage("commands.whitelist.status")));
            }
            if($args[0] == "on") {
                Main::$whitelist->set("Status", true);
                Main::$whitelist->save();
                $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.on"));
            }
            if($args[0] == "off") {
                Main::$whitelist->set("Status", false);
                Main::$whitelist->save();
                $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.off"));
            }
            if($args[0] == "list") {
                $PlayersNick = Main::$whitelist->get("NickPlayers");
                $sender->sendMessage(str_replace("{PLAYERS}", "§9".implode("§8, §9", $PlayersNick), ConfigUtil::getMessage("commands.whitelist.list")));
               // Format::sendMessage($player, 2, "Lista graczy dodanych na whiteliste: &6".implode("&8, &6", $PlayersNick));
            }
            if($args[0] == "add") {
                if (isset($args[1])) {
                    //SMALL NAME PLAYERS
                    $nick = strtolower($args[1]);
                    //DOWNLiOAD NAME PLAYERS
                    $PlayersNick = Main::$whitelist->get("NickPlayers");

                    if (in_array($nick, $PlayersNick)) {
                        $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.add"));
                        return true;
                    }
                    $PlayersNick[] = $nick;
                    Main::$whitelist->set("NickPlayers", $PlayersNick);
                    Main::$whitelist->save();
                    $sender->sendMessage(str_replace("{NAME}", $nick, ConfigUtil::getMessage("commands.whitelist.added")));
                } else {
                    $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.addusage"));
                }
            }

            if($args[0] == "remove") {
                if(isset($args[1])) {
                    $nick = strtolower($args[1]);
                    $PlayersNick = Main::$whitelist->get("NickPlayers");

                    if(!in_array($nick, $PlayersNick)) {
                        $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.donthave"));
                        return true;
                    }

                        unset($PlayersNick[array_search($nick, $PlayersNick)]);
                        $array = [];
                    foreach ($PlayersNick as $deletePlayer)
                        $array[] = $deletePlayer;
                        Main::$whitelist->set("NickPlayers", $array);
                        Main::$whitelist->save();

                    $sender->sendMessage(str_replace("{NAME}", $nick, ConfigUtil::getMessage("commands.whitelist.removep")));
                } else {
                    $sender->sendMessage(ConfigUtil::getMessage("commands.whitelist.removeuse"));
                }
            }
        }

        return true;
    }
}