<?php

namespace Core\listener;

use Core\CorePlayer;
use pocketmine\Server;
use pocketmine\utils\TextFormat;
use Core\listener\events\{
	JoinEvent,
	PlayerChatListener,
	BlockBreakListener,
	ChatListener,
	UpdateGroupListener,
	LevelChangeListener,
	QuitListener,
	BlockPlaceListener,
	EntityDamageListener,
	PlayerMoveListener,
	PlayerPreJoinListener,
	PlayerDeathListener,
	EventListener,
	PlayerRespawnListener,
	PlayerInteractListener,
	PlayerCommandPreprocessListener
};
use Core\listener\events\inventory\InventoryTransactionListener;
use Core\listener\events\packet\DataPacketReceiveListener;
use Core\listener\events\packet\DataPacketSendListener;
use Core\listener\events\player\PlayerCreationListener;

use Core\Main;

class ListenerManager {
	
	public static function init() {
		
		$events = [
		 new JoinEvent(),
		 new EventListener(),
		 new PlayerChatListener(),
		 new BlockBreakListener(),
		 new ChatListener(),
		 new BlockPlaceListener(),
	     new UpdateGroupListener(),
	     new QuitListener(),
	     new PlayerInteractListener(),
	     new PlayerCommandPreprocessListener(),
	     new PlayerPreJoinListener(),
	     new PlayerMoveListener(),
	     new EntityDamageListener(),
            new InventoryTransactionListener(),
            new DataPacketReceiveListener(),
           // new DataPacketSendListener(),
            new PlayerCreationListener(),
		];
		  foreach($events as $event) {	Server::getInstance()->getPluginManager()->registerEvents($event, Main::getInstance());
		}
		Server::getInstance()->getLogger()->info(TextFormat::DARK_GREEN . "Zarejestrowane wszystkie eventy pomsylnie");
	}
}