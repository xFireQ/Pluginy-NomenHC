<?php
namespace Core\modules;

use Core\format\Permission;
use Core\Main;
use Core\managers\WebhookManager;
use Core\user\UserManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\item\Item;

class Reach implements Listener{
    
    private $plugin;
    private $notify;
    private $distance;
    
    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->notify = [];
        $this->distance = [];
    }
    
    public function onEntityDamageEvent(EntityDamageEvent $e){
        if($e instanceof EntityDamageByEntityEvent){
            $attacker = $e->getMetar();

            if(!($attacker instanceof Player)) return;



            if(Permission::isOp($player)) return;
            if($attacker->isCreative(true)) return;
            if($attacker->getInventory()->getItemInHand()->getId() == \pocketmine\item\ItemIds::BOW ||
                $attacker->getInventory()->getItemInHand()->getId() == \pocketmine\item\ItemIds::ENDER_PEARL ||
                $attacker->getInventory()->getItemInHand()->getId() == \pocketmine\item\ItemIds::EGG ||
                $attacker->getInventory()->getItemInHand()->getId() == \pocketmine\item\ItemIds::SNOWBALL) {
                return;
            }
            $victim = $e->getEntity();
            $player = $e->getEntity();
            $distance = $attacker->distance($victim->getPosition());
            if($distance > 5){
                if(!isset($this->notify[$attacker->getName()])){
                    $this->notify[$attacker->getName()] = 0;
                }
                $this->notify[$attacker->getName()]++;
                $this->distance[$attacker->getName()][] = $distance;
                if($this->notify[$attacker->getName()] >= 5){
                    foreach($this->plugin->getServer()->getOnlinePlayers() as $ops){
                        if($ops->getPlayer()->hasPermission("NomenHC.helpop")){
                            $dist = array_sum($this->distance[$attacker->getName()]) / count($this->distance[$attacker->getName()]);
                            if (isset(UserManager::$ac[$ops->getName()]))
                                $ops->getPlayer()->sendMessage("§c§lANYCHEAT §r§7Gracz §c{$player->getName()} §7moze uzywac §cREACH ( ".$dist." )");
                        }
                    }
                    $this->distance[$attacker->getName()] = null;
                    $this->notify[$attacker->getName()] = 0;
                }
            }
        }
    }
}

