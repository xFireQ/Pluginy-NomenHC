<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\format\Permission;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerChatEvent;
use Core\Main;
use Core\managers\{
    ChatManager, FormatManager
};
use pocketmine\math\Vector3;
use pocketmine\Server;

class ChatListener implements Listener {

    /**
     * @param PlayerChatEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function chatFormat(PlayerChatEvent $e) {
        $player = $e->getPlayer();
        $groupManager = Main::getInstance()->getGroupManager();

        $group = $groupManager->getPlayer($player->getName())->getGroup();

        if($group != null && $group->getFormat() != null) {
            $format = FormatManager::getFormat($player, $group->getFormat(), $e->getMessage());

            if(!ChatManager::isChatPerWorld())
                $e->setFormat($format);
            else {
                $e->cancel(true);

                foreach($player->getWorld()->getPlayers() as $p)
                    $p->sendMessage($format);
            }
        }
    }
}