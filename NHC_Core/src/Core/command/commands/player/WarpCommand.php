<?php

namespace Core\command\commands\player;

use Core\warps\WarpsManager;
use pocketmine\player\Player;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Core\util\ConfigUtil;
use Core\Main;
use pocketmine\math\Vector3;
use pocketmine\world\Position;

class WarpCommand extends Command {
    public function __construct() {
        parent::__construct("warp", "komenda warp", true, ["event"]);
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args): bool {


        if(empty($args)) {
            $warps = WarpsManager::getWarps();
            $sender->sendMessage("§r§8» §7Warpy: §9".implode("§8,§9 ", $warps));
            if($sender->isOp()) {
                $sender->sendMessage("§r§7Poprawne uzycie §9/warp create/delete");

            }
            return true;
        }

        if(isset($args)) {
            $warps = WarpsManager::getWarps();
            foreach ($warps as $warp) {
                if($args[0] == "".$warp) {
                    //$sender->teleport(new Vector3(WarpsManager::getWarpPos($warp, "x"), WarpsManager::getWarpPos($warp, "y"), WarpsManager::getWarpPos($warp, "z")));
                    $sender->sendMessage("§r§8» §7Pomyslnie przeteleportowano sie na warpa: §9".$warp." §8!");
                }
            }
        }

        if($sender->isOp()) {
            if(isset($args[0])) {
                if($args[0] == "create") {
                    if(isset($args[1])) {
                        WarpsManager::addWarp("".$args[1], $sender->getPosition()->getX(), $sender->getPosition()->getY(), $sender->getPosition()->getZ());
                        $sender->sendMessage("§r§8» §7Stworzono warp: §9".$args[1]);
                    }
                }

                if($args[0] == "delete") {
                    if(isset($args[1])) {
                        WarpsManager::removeWarp($args[1]);
                        $sender->sendMessage("§r§8» §7Usunieto warp: §9".$args[1]);

                    }
                }
            }
        }
        return true;
    }
}