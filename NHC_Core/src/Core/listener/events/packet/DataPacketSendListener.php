<?php

namespace Core\listener\events\packet;

use Core\fakeinventory\FakeInventoryManager;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketSendEvent;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;

class DataPacketSendListener implements Listener {

    /**
     * @param DataPacketSendEvent $e
     * @priority LOW
     * @ignoreCancelled true
     */
    public function onDataPacketSend(DataPacketSendEvent $e) : void{
    }

}