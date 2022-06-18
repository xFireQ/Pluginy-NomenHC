<?php

declare(strict_types=1);

namespace Core\command\default;

use Core\util\ConfigUtil;
use pocketmine\command\Command;
use Core\managers\ProtectManager;
use Core\utils\FormatUtils;
use Core\utils\GlobalVariables;
use pocketmine\level\Level;
use pocketmine\command\CommandSender;

class ProtectCommand extends Command {

	public function __construct() {
		parent::__construct("protect", "Komenda protect");
	}

	public function execute(CommandSender $sender, string $label, array $args) : void {
        if(!$sender->hasPermission("NomenHC.op")) {
            $sender->sendMessage(ConfigUtil::getMessage("messages.permissions", false));
            return;
        }

	    if(empty($args)) {
            $sender->sendMessage("§8» §7Uzyj:");
            $sender->sendMessage("§8» §7/protect create");
            $sender->sendMessage("§8» §7/protect delete");
            $sender->sendMessage("§8» §7/protect add");
            $sender->sendMessage("§8» §7/protect remove");
            $sender->sendMessage("§8» §7/protect flag");
            $sender->sendMessage("§8» §7/protect whiteblock");
	        return;
        }

	    $nick = $sender->getName();

	    switch($args[0]) {

            case "whiteblock":
                if(!isset($args[1])) {
                    $sender->sendMessage("§8» §7Poprawne uzycie: /protect whiteblock §8(§9set§8|§9remove§8)");
                    return;
                }

                switch($args[1]) {
                    case "set":
                        if(isset(GlobalVariables::$setWhiteBlock[$nick])) {
                            $sender->sendMessage("§8» §7Ustawianie bialych blokow zostalo wylaczone");
                            unset(GlobalVariables::$setWhiteBlock[$nick]);
                            return;
                        }

                        if(!isset($args[2])) {
                            $sender->sendMessage("§8» §7Poprawne uzycie: /protect whiteblock set §8(§9teren§8)");
                            return;
                        }

                        if(!ProtectManager::isTerrainExists($args[2])) {
                            $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                            return;
                        }

                        GlobalVariables::$setWhiteBlock[$nick] = $args[2];
                        $sender->sendMessage("§8» §7Kliknij na blok ktory chcesz dodac do bialej listy");
                    break;

                    case "remove":
                        if(isset(GlobalVariables::$removeWhiteBlock[$nick])) {
                            $sender->sendMessage("§8» §7Usuwanie bialych blokow zostalo wylaczone");
                            unset(GlobalVariables::$removeWhiteBlock[$nick]);
                            return;
                        }

                        if(!isset($args[2])) {
                            $sender->sendMessage("§8» §7Poprawne uzycie: /protect whiteblock remove §8(§9teren§8)");
                            return;
                        }

                        if(!ProtectManager::isTerrainExists($args[2])) {
                            $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                            return;
                        }

                        GlobalVariables::$removeWhiteBlock[$nick] = $args[2];
                        $sender->sendMessage("§8» §7Kliknij na blok ktory chcesz usunac z bialej listy");
                    break;
                }
            break;

            case "list":
                if(!isset($args[1])) {
                    $sender->sendMessage("§8» §7Stworzone tereny: §9" . implode("§8, §9", ProtectManager::getTerrains()));
                    return;
                }

                if(!ProtectManager::isTerrainExists($args[1])) {
                    $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                    return;
                }

                $sender->sendMessage("§8» §7Dodani gracze: §9" . implode("§8, §9", ProtectManager::getPlayers($args[1])));
            break;

            case "create":
                if(isset($args[2])) {
                    $terrainName = $args[1];
                    $terrainSize = $args[2];

                    if(!is_numeric($args[2])) {
                        $sender->sendMessage("§8» §7Argument §92 §7musi byc numeryczny!");
                        return;
                    }

                    if(ProtectManager::isTerrainExists($terrainName)) {
                        $sender->sendMessage("§8» §7Teren o takiej nazwie juz istnieje!");
                        return;
                    }

                    $arm = floor($terrainSize / 2);

                    $pos1 = $sender->add($arm, 0, $arm);
                    $pos1->setComponents($pos1->getX(), 0, $pos1->getZ());

                    $pos2 = $sender->add(-$arm, 0, -$arm);
                    $pos2->setComponents($pos2->getX(), Level::Y_MAX, $pos2->getZ());

                    ProtectManager::createTerrain($terrainName, [$pos1, $pos2]);
                    $sender->sendMessage("§8» §7Teren §9{$terrainName} §7zostal utworzony");
                    return;
                }
                if(!isset(ProtectManager::$data[$nick])) {
                    ProtectManager::$data[$nick] = [];
                    $sender->sendMessage("§8» §7Wybierz §91 §7pozycje");
                } else {
                    unset(ProtectManager::$data[$nick]);
                    $sender->sendMessage("§8» §7Tworzenie terenu zostalo anulowane");
                }
            break;

            case "delete":
                if(!isset($args[1])) {
                    $sender->sendMessage("§8» §7Poprawne uzycie: /protect delete §8(§9nazwa§8)");
                    return;
                }

                if(!ProtectManager::isTerrainExists($args[1])) {
                    $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                    return;
                }

                ProtectManager::deleteTerrain($args[1]);
                $sender->sendMessage("§8» §7Teren §9{$args[1]} §7zostal usuniety");
            break;

            case "flag":
                if(!isset($args[2])) {
                    $sender->sendMessage("/protect flag (nazwa terenu) (list/set/remove)");
                    return;
                }

                if(!ProtectManager::isTerrainExists($args[1])) {
                    $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                    return;
                }


                switch($args[2]) {
                    case "list":
                        $flagsFormat = ["Flagi terenu §9{$args[1]}§7:"];

                        foreach(ProtectManager::getFlags($args[1]) as $flag => $status)
                                $flagsFormat[] = "{$flag}: ".($status ? "§9ON" : "§9OFF");

                        $sender->sendMessage(FormatUtils::messageFormatLines($flagsFormat));
                    break;

                    case "set":
                        if(!isset($args[3])) {
                            $sender->sendMessage("§8» §7Poprawne uzycie: /protect flag $args[1] set §8(§9flaga§8)");
                            return;
                        }

                        if(!ProtectManager::isFlagExists($args[3])) {
                            $sender->sendMessage("§8» §7Ta flaga nie istnieje!");
                            return;
                        }

                        ProtectManager::setFlag($args[1], $args[3]);
                        $sender->sendMessage("§8» §7Wlaczono flage §9{$args[3]} §7dla terenu §9{$args[1]}");
                    break;

                    case "remove":
                        if(!isset($args[3])) {
                            $sender->sendMessage("§8» §7Poprawne uzycie: /protect flag $args[1] remove §8(§9flaga§8)");
                            return;
                        }

                        if(!ProtectManager::isFlagExists($args[3])) {
                            $sender->sendMessage("§8» §7Ta flaga nie istnieje!");
                            return;
                        }

                        ProtectManager::setFlag($args[1], $args[3], false);
                        $sender->sendMessage("§8» §7Wylaczono flage §9{$args[3]} §7dla terenu §9{$args[1]}");
                    break;
                }
            break;

            case "add":
                if(!isset($args[2])) {
                    $sender->sendMessage("§8» §7Poprawne uzycie: /protect add §8(§9teren§8) (§9nick§8)");
                    return;
                }

                if(!ProtectManager::isTerrainExists($args[1])) {
                    $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                    return;
                }

                ProtectManager::addPlayer($args[1], $args[2]);
                $sender->sendMessage("§8» §7Dodano gracza §9{$args[2]} §7do terenu §9{$args[1]}");
            break;

            case "remove":
                if(!isset($args[2])) {
                    $sender->sendMessage("§8» §7Poprawne uzycie: /protect remove §8(§9teren§8) (§9nick§8)");
                    return;
                }

                if(!ProtectManager::isTerrainExists($args[1])) {
                    $sender->sendMessage("§8» §7Teren o takiej nazwie nie istnieje!");
                    return;
                }

                ProtectManager::removePlayer($args[1], $args[2]);
                $sender->sendMessage("§8» §7Usunieto gracza §9{$args[2]} §7z terenu §9{$args[1]}");
            break;

            default:
                $sender->sendMessage("§8» §7Nieznany argument!");
        }
    }
}