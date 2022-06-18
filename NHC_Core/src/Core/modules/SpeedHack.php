<?php
namespace Core\modules;

use Core\managers\WebhookManager;
use Core\user\UserManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\entity\Effect;
use Core\Main;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerMoveEvent;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\math\Vector3;

class SpeedHack implements Listener{
    
    private $plugin;
    private $player;
    
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->player = [];
    }
    
    public function on(PlayerJoinEvent $e){
        $this->player[$e->getPlayer()->getName()] = 0;
    }
    
    public function onPlayerMoveEvent(PlayerMoveEvent $e){
        if($e->getFrom()->floor()->equals($e->getTo()->floor()))
            return;

        $player = $e->getPlayer();

        
        if($player->isOp() || $player->hasPermission("antycheat.bypass")) return;
        if($player->isCreative(true) || $player->isSpectator()) return;
        $x = $player->getPosition()->getFloorX();
        $y = $player->getPosition()->getFloorY();
        $z = $player->getPosition()->getFloorZ();
        if($player->getWorld()->getBlock(new Vector3($x, $y - 1, $z))->getId() == 0) return;
        $dist = $e->getFrom()->distanceSquared($e->getTo());
        $ping = ($player->getPing() / 100);
        $minimum = 0.80 + $ping;
        if($player->getEffect(Effect::SPEED) !== null)
            $minimum += (($player->getEffect(Effect::SPEED)->getEffectLevel() / 10) / 2);

        if($dist >= $minimum){
            $this->player[$player->getName()]++;
            if($this->player[$player->getName()] >= 10){
                foreach($this->plugin->getServer()->getOnlinePlayers() as $ops){
                    if($ops->getPlayer()->hasPermission("ac.admin")){
                        if (isset(UserManager::$ac[$ops->getName()]))
                            $ops->getPlayer()->sendMessage("§c§lANYCHEAT §r§7Gracz §c{$player->getName()} §7moze uzywac §cSPEEDHACK");
                    }
                }


                $this->plugin->getServer()->getLogger()->warning($player->getName() . " -> SpeedHack( $dist )");
                $this->player[$player->getName()] = 0;
            }
        }
    }
    
}

