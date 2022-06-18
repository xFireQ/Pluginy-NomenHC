<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
    Command, CommandSender, ConsoleCommandSender
};
use pocketmine\Server;
use Core\format\Format;
use Core\format\Permission;
use Core\command\BaseCommand;
use Core\Main;
use Core\task\WhiteListTask;
use Core\user\User;
use pocketmine\player\Player;
use pocketmine\math\Vector3;

class WhitelistCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("whitelist", "Komenda whitelist", ["wl", "lobby"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        if(empty($args)) {
            Format::sendMessage($sender, 1, "POPRAWNE UZYCIE TO:");
            Format::sendMessage($sender, 1, "&9/whitelist &8[&9add&8/&9remove&8/&9status&8/&9on&8/&9off&8/&9list&8/&9format&8]");
            return;
        }

        if (isset($args)) {
            if($args[0] == "format") {
                if(isset($args[1])) {
                    $newformat = "";
                    for ($i = 1; $i <= count($args) - 1; $i++)
                        $newformat .= $args[$i] . " ";

                    Main::$whitelist->set("KickMessage", "&r" . $newformat);
                    Main::$whitelist->save();
                    Format::sendMessage($sender, 1, "Format zostal zmieniony na: \n".$newformat);

                } else {
                    Format::sendMessage($sender, 1, "Poprawne uzycie &9/whitelist format &8[&9format&8]");
                }
            }

            if($args[0] == "status") {
                $status = Main::$whitelist->get("Status");
                if($status == true) {
                    $status = "WLACZONA";
                } else {
                    $status = "WYLACZONA";
                }
                Format::sendMessage($sender, 2, "WhiteLista aktualnie jest &9".$status);

            }
            if($args[0] == "on") {
                Main::$whitelist->set("date", 0);
                Main::$whitelist->set("Status", true);
                Main::$whitelist->save();
                Format::sendMessage($sender, 2, "Whitelista zostala wlaczona! ");

                foreach (Server::getInstance()->getOnlinePlayers() as $onlinePlayer) {
                    $nick = strtolower($onlinePlayer->getName());
                    //DOWNLiOAD NAME PLAYERS
                    $PlayersNick = Main::$whitelist->get("NickPlayers");

                    if (!in_array($nick, $PlayersNick) or !Permission::isOp($onlinePlayer)) {
                        $onlinePlayer->kick("Zostales wyrzucony z serwera z powodem whitelista", false);
                    }
                }
            }
            if($args[0] == "off") {
                Main::$whitelist->set("Status", false);
                Main::$whitelist->save();
                Format::sendMessage($sender, 2, "WhiteLista zostala wylaczona!");
            }
            if($args[0] == "list") {
                $PlayersNick = Main::$whitelist->get("NickPlayers");
                
                //$sender->sendMessage(str_replace("{PLAYERS}", "§9".implode("§8, §9", $PlayersNick), ConfigUtil::getMessage("commands.whitelist.list")));
                 Format::sendMessage($sender, 2, "Lista graczy dodanych na whiteliste: &9".implode("&8, &9", $PlayersNick));
            }
            if($args[0] == "add") {
                if (isset($args[1])) {
                    //SMALL NAME PLAYERS
                    $nick = strtolower($args[1]);
                    //DOWNLiOAD NAME PLAYERS
                    $PlayersNick = Main::$whitelist->get("NickPlayers");

                    if (in_array($nick, $PlayersNick)) {
                        Format::sendMessage($sender, 1, "Ten gracz jest juz dodany na whiteliste!");
                        return;
                    }
                    $PlayersNick[] = $nick;
                    Main::$whitelist->set("NickPlayers", $PlayersNick);
                    Main::$whitelist->save();
                    Format::sendMessage($sender, 1, "Dodano gracza &9".$nick." &7na biala liste!");
                } else {
                    Format::sendMessage($sender, 1, "Poprawne uzycie &9/whitelist add &8[&9nick&8]");
                }
            }

            if($args[0] == "remove") {
                if(isset($args[1])) {
                    $nick = strtolower($args[1]);
                    $PlayersNick = Main::$whitelist->get("NickPlayers");

                    if(!in_array($nick, $PlayersNick)) {
                        Format::sendMessage($sender, 1, "Ten gracz nie jest dodany na whiteliste!");
                        return;
                    }

                    unset($PlayersNick[array_search($nick, $PlayersNick)]);
                    $array = [];
                    foreach ($PlayersNick as $deletePlayer)
                        $array[] = $deletePlayer;
                    Main::$whitelist->set("NickPlayers", $array);
                    Main::$whitelist->save();

                    Format::sendMessage($sender, 1, "Gracz &9".$nick." &7zostal usuniety z bialej listy!");
                } else {
                    Format::sendMessage($sender, 1, "Poprawne uzycie &9/whitelist remove &8[&9nick&8]");
                }
            }
        }
        return;
    }
}