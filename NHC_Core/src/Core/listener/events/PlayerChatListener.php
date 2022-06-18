<?php

namespace Core\listener\events;

use Core\managers\ProtectManager;
use Core\util\GlobalVariables;
use pocketmine\player\Player;
use Core\user\UserManager;
use Core\util\FormatUtils;

use pocketmine\event\Listener;
use Core\utils\Utils;
use Core\Main;

use Core\settings\SettingsManager;

use pocketmine\event\player\PlayerChatEvent;

class PlayerChatListener implements Listener {

    public function protectCreateTerrain(PlayerChatEvent $e) {
        $player = $e->getPlayer();
        $nick = $player->getName();
        $api = Main::getInstance()->getMuteAPI();
        $terrainName = $e->getMessage();

       /* if($api->isMuted($nick)) {
            $e->cancel();
            $player->sendMessage($api->getMuteMessage($player));
        }*/

        if(isset(ProtectManager::$data[$nick])) {
            if(isset(ProtectManager::$data[$nick][0]) && isset(ProtectManager::$data[$nick][1])) {
                $e->cancel(true);
                if(ProtectManager::isTerrainExists($terrainName)) {
                    $player->sendMessage("§8» §7Teren o takiej nazwie juz istnieje, uzyj innej nazwy");
                    return;
                }

                ProtectManager::createTerrain($terrainName, ProtectManager::$data[$nick]);
                $player->sendMessage("§8» §7Teren o nazwie §a{$terrainName} §7zostal utworzony");
                unset(ProtectManager::$data[$nick]);
            }
        }
    }

    public function mute(PlayerChatEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        $api = Main::getInstance()->getMuteAPI();

        if ($api->isMuted($nick)) {
            $e->cancel(true);
            $player->sendMessage($api->getMuteMessage($player));
        }
    }


    public function AntySpam(PlayerChatEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        if ($player->hasPermission("NomemHC.chat.spam")) return;

        isset(Main::$lastChatMsg[$nick]) ? $time = Main::$lastChatMsg[$nick] : $time = 0;

        if (time() - $time < 10) {
            $e->cancel(true);

            $player->sendMessage(Main::format("Nastepna wiadomosc mozesz napisac za §9" . (10 - (time() - $time)) . " §7sekund!"));
        } else
            Main::$lastChatMsg[$nick] = time();
    }

    
	
	public function Chat(PlayerChatEvent $e) {
		$player = $e->getPlayer();
		$nick = $player->getName();
		if(Main::$chatOn == true) {
		    if(!$player->hasPermission("NomenHC.chat")) {
		       $e->cancel();
		       $player->sendMessage(Main::format("Chat jest aktualnie §9wylaczony"));
		    }
		}
	}
	
	/*ublic function mute(PlayerChatEvent $e) {
        $player = $e->getPlayer();
        $nick = $player->getName();

        $user = UserManager::getUser($player);

        if($user->isMuted()) {
            $e->cancel(true);
            $player->sendMessage(FormatUtils::muteFormat($user->getMuteReason(), $user->getMuteAdmin(), $user->getMuteDate()));
        }
    }*/
}