<?php

namespace Core\command\default;

use Core\format\Permission;
use Core\util\ConfigUtil;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\player\GameMode;
use pocketmine\Server;
use pocketmine\player\Player;

class GamemodeCommand extends Command
{
    public function __construct() {
        parent::__construct("gamemode", "komenda gamemode", true, ["gm"]);
    }

    public function execute(CommandSender $sender, String $label, array $args): void {
        if(Permission::has($sender, "NomenHC.command.gamemode")) {
            if(empty($args)){
                $msg = ConfigUtil::getMessage("commands.gm.empty");
                foreach ($msg as $mess) {
                    $sender->sendMessage($mess);
                }
                return;
            }
            if(isset($args[0])) {
                if (isset($args[1])) {
                    $player = Server::getInstance()->getPlayerExact($args[1]);
                    $name = $player == null ? $args[1] : $player->getName();
                    $tryb = [
                        "PRZETRWANIE",
                        "KREATYWNY",
                        "PRZYGODOWY",
                        "WIDZ"
                    ];

                    if ($name == null or $player == null) {
                        $sender->sendMessage(ConfigUtil::getMessage("messages.poffline", false));
                        return;
                    }

                    if ($args[0] == "0") {
                        $player->setGamemode(GameMode::SURVIVAL());
                        $message = ConfigUtil::getMessage("commands.gm.gamemodep");
                        $message = str_replace("{TRYB}", $tryb[0], $message);
                        $message = str_replace("{NAME}", $name, $message);
                        $player->sendMessage($message);
                        return;
                    }
                    if ($args[0] == "1") {
                        $player->setGamemode(GameMode::CREATIVE());
                        $message = ConfigUtil::getMessage("commands.gm.gamemodep");
                        $message = str_replace("{TRYB}", $tryb[1], $message);
                        $message = str_replace("{NAME}", $name, $message);
                        $player->sendMessage($message);
                        return;
                    }
                    if ($args[0] == "2") {
                        $player->setGamemode(GameMode::ADVENTURE());
                        $message = ConfigUtil::getMessage("commands.gm.gamemodep");
                        $message = str_replace("{TRYB}", $tryb[2], $message);
                        $message = str_replace("{NAME}", $name, $message);
                        $player->sendMessage($message);
                        return;
                    }
                    if ($args[0] == "3") {
                        $player->setGamemode(GameMode::SPECTATOR());
                        $message = ConfigUtil::getMessage("commands.gm.gamemodep");
                        $message = str_replace("{TRYB}", $tryb[3], $message);
                        $message = str_replace("{NAME}", $name, $message);
                        $player->sendMessage($message);
                        return;
                    }

                }
            }

            if(isset($args[0])) {
                if ($sender instanceof Player) {
                    $tryb = [
                        "PRZETRWANIE",
                        "KREATYWNY",
                        "PRZYGODOWY",
                        "WIDZ"
                    ];
                    if ($args[0] == "0") {
                        $sender->setGamemode(GameMode::SURVIVAL());
                        $sender->sendMessage(str_replace("{TRYB}", $tryb[0], ConfigUtil::getMessage("commands.gm.gamemode"), ));
                        return;
                    }
                    if ($args[0] == "1") {
                        $sender->setGamemode(GameMode::CREATIVE());
                        $sender->sendMessage(str_replace("{TRYB}", $tryb[1], ConfigUtil::getMessage("commands.gm.gamemode"), ));
                        return;
                    }
                    if ($args[0] == "2") {
                        $sender->setGamemode(GameMode::ADVENTURE());
                        $sender->sendMessage(str_replace("{TRYB}", $tryb[2], ConfigUtil::getMessage("commands.gm.gamemode"), ));
                        return;
                    }
                    if ($args[0] == "3") {
                        $sender->setGamemode(GameMode::SPECTATOR());
                        $sender->sendMessage(str_replace("{TRYB}", $tryb[3], ConfigUtil::getMessage("commands.gm.gamemode"), ));
                        return;
                    }
                } else {
                    $sender->sendMessage(ConfigUtil::getMessage("messages.console"));
                }
            }

        } else {
            $sender->sendMessage(ConfigUtil::getMessage("messages.permissions", false));
        }
    }
}