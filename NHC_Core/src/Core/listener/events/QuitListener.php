<?php

declare(strict_types=1);

namespace Core\listener\events;

use pocketmine\console\ConsoleCommandSender;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerQuitEvent;
use Core\Main;
use Core\managers\SkinManager;
use pocketmine\lang\Language;
use pocketmine\Server;

class QuitListener implements Listener {
	
	public function unregisterPlayer(PlayerQuitEvent $e) {
		Main::getInstance()->getGroupManager()->unregisterPlayer($e->getPlayer());
	}

    public function onQuit(PlayerQuitEvent $event) : void {
        $player = $event->getPlayer();
        SkinManager::removePlayerSkin($player);
    }
	
	public function SprawdzanieBanOnQuit(PlayerQuitEvent $e)
    {
        $player = $e->getPlayer();
        $nick = $player->getName();

        if (isset(Main::$spr[$nick])) {
            //$api = Main::getInstance()->getBanAPI();

            //$api->setBan($nick, "Cheaty", Main::$spr[$nick][1]);
            
            $player->getServer()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender(), "ban $nick CHEATY");

            unset(Main::$spr[$nick]);

            //$player->teleport($player->getWorld()->getSafeSpawn());

            Server::getInstance()->broadcastMessage(Main::format("Gracz §9$nick §7wylogowal sie podczas sprawdzania!"));
        }
    }
    
    
}