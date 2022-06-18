<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\Main;
use pocketmine\event\Listener;
use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\network\mcpe\protocol\LoginPacket;
use Core\managers\SkinManager;
use Core\util\SkinUtil;

class DataPacketReceiveListener implements Listener {

   /* public function setNameTagDevice(DataPacketReceiveEvent $e)
    {
        $packet = $e->getPacket();

        if ($packet instanceof LoginPacket) {
            $player = $e->getPlayer();
            $device = "?";

            switch ($packet->clientData["DeviceOS"]) {
                case 1:
                    $device = "?";
                case 2:
                    $device = "MOBILE";
                    break;

                case 7:
                    $device = "Windows10";
                    break;

                default:
                    $device = "KONSOLA";
            }
            if($device == "KONSOLA" or $device == "?") {
                $data = $packet->clientData;
                $name = $data["ThirdPartyName"];
                SkinManager::setPlayerDefaultSkin($name);

            }
        }
    }*/

    /*public function onLogin(DataPacketReceiveEvent $event) : void {
        $packet = $event->getPacket();

        if($packet instanceof LoginPacket) {
            $data = $packet->clientDataJwt;
            $name = $data["ThirdPartyName"];

            if($data["PersonaSkin"]) {
                SkinManager::setPlayerDefaultSkin($name);
                return;
            }

            $image = SkinUtil::skinDataToImage(base64_decode($data["SkinData"], true));

            // DOPUSZCZALNE SĄ TYLKO SKINY 64x64
            if($image === null || imagesx($image) * imagesy($image) * 4 !== 16384) {
                SkinManager::setPlayerDefaultSkin($name);
                return;
            }

            SkinManager::setPlayerSkinImage($name, $image);
        }
    }*/
}