<?php
namespace Core\modules;

use Core\format\Permission;
use Core\Main;
use Core\managers\WebhookManager;
use Core\user\UserManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\math\Vector3;

class Noclip implements Listener{
    
    private $plugin;
    private $player;
    private $counter;
    
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->player = [];
    }
    
    public function onPlayerJoinEvent(PlayerJoinEvent $e){
        $this->player[$e->getPlayer()->getName()] = 0;
        $this->counter[$e->getPlayer()->getName()] = 0;
    }
    
    public function onPlayerMoveEvent(PlayerMoveEvent $e){

        if($e->getFrom()->floor()->equals($e->getTo()->floor()))
            return;

        $player = $e->getPlayer();



        if(Permission::isOp($player)) return;
        if($player->isSpectator()) return;

        if(isset(Main::$noclipWhitelist[$player->getName()])){
            if(Main::$noclipWhitelist[$player->getName()] >= time() + 5) {
                $e->cancel();
                return;
            }
        }

        $x1 = $e->getTo()->getFloorX();
        $y1 = $e->getTo()->getFloorY();
        $z1 = $e->getTo()->getFloorZ();
        $b1 = $e->getTo()->getWorld()->getBlock(new Vector3($x1, $y1, $z1))->getId();
        $b2 = $e->getTo()->getWorld()->getBlock(new Vector3($x1, $y1 + 1, $z1))->getId();
        $x2 = $player->getPosition()->getFloorX();
        $y2 = $player->getPosition()->getFloorY();
        $z2 = $player->getPosition()->getFloorZ();
        $b3 = $player->getWorld()->getBlock(new Vector3($x2, $y2, $z2))->getId();
        $b4 = $player->getWorld()->getBlock(new Vector3($x2, $y2 + 1, $z2))->getId();
        $allowed = [44, 160, 102, 186, 187, 185, 184, 85, 139, 183, 107, 113, 101, 203, 156, 114, 108, 180, 128, 109, 164, 136,
            135, 134, 53, 67, 26, 194, 64, 193, 195, 196, 197, 71, 167, 96, 331, 69, 126, 28, 27, 66, 76, 44, 182, 168, 171,
            6, 31, 175, 38, 37, 32, 111, 106, 30, 78, 39, 40, 116, 117, 54, 146, 130, 199, 140, 144, 120, 208, 63, 68, 158, 59,
            104, 105, 244, 141, 142, 132, 72, 70, 147, 148, 143, 77, 176, 177, 8, 9, 10, 11, 65, 50, 0, 43, 338, 83
        ];

        if(in_array($b1, $allowed) || in_array($b2, $allowed) || in_array($b3, $allowed) || in_array($b4, $allowed))
            return;
        if($b1 !== 0 || $b2 !== 0 || $b3 !== 0 || $b4 !== 0){
            $e->cancel();
            $this->player[$e->getPlayer()->getName()]++;
            if($this->player[$e->getPlayer()->getName()] >= 10){
                foreach($this->plugin->getServer()->getOnlinePlayers() as $ops){
                    if($ops->getPlayer()->hasPermission("NomenHC.helpop")){
                        if (isset(UserManager::$ac[$ops->getName()]))
                            $ops->getPlayer()->sendMessage("§c§lANYCHEAT §r§7Gracz §c{$player->getName()} §7moze uzywac §cNO-CLIP");
                    }
                }
                $this->player[$e->getPlayer()->getName()] = 0;
            }
        }
    }
}

