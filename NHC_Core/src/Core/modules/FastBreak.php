<?php
namespace Core\modules;

use Core\format\Permission;
use Core\managers\WebhookManager;
use Core\task\GamemodeTask;
use Core\user\UserManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\entity\Effect;
use pocketmine\entity\effect\VanillaEffects;
use pocketmine\player\GameMode;
use pocketmine\Server;
use Core\Main;
use pocketmine\event\Listener;
use pocketmine\event\block\BlockBreakEvent;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\event\player\PlayerQuitEvent;

class FastBreak implements Listener{
    
    private $breakTimes = [];
    private $notify;
    private $plugin;
    private $counter;

    public function __construct(Main $plugin){
        $this->plugin = $plugin;
        $this->notify = [];
    }
    
    public function onPlayerInteract(PlayerInteractEvent $event){

        $player = $event->getPlayer();

        if($event->getAction() === PlayerInteractEvent::LEFT_CLICK_BLOCK){
            $this->breakTimes[$player->getName()] = floor(microtime(true) * 20);
        }
    }

    /**
     * @param BlockBreakEvent $e
     * @priority HIGHEST
     * @ignoreCancelled true
     */

    public function AntiSpeedMineBlockBreak(BlockBreakEvent $e) : void{

        if($e->isCancelled())
            return;

        if($e->getInstaBreak())
            return;

        $player = $e->getPlayer();

        
        $name = $player->getName();

        if(!isset($this->counter[$name])) {
            $this->counter[$name] = 1;
            return;
        }

        if(!isset($this->breakTimes[$name])){

            $e->cancel(true);

            if($this->counter[$name] >= 6) {
                $player->setGamemode(GameMode::ADVENTURE());
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new GamemodeTask(4, $player), 20);
                foreach($this->plugin->getServer()->getOnlinePlayers() as $ops){
                    if(Permission::isOp($player)){
                        if (isset(UserManager::$ac[$ops->getName()]))
                            $ops->getPlayer()->sendMessage("§c§lANYCHEAT §r§7Gracz §4{$player->getName()} §7moze uzywac §4FASTBREAK");

                    }
                }

                Server::getInstance()->getLogger()->error("[ANTYCHEAT] §r§8(§7".$player->getName()."§8) §7 Prawdopodobnie korzysta z fastbreaka!");

                $this->counter[$name] = 0;
                return;
            }else
                $this->counter[$name]++;

            return;
        }

        $target = $e->getBlock();
        $item = $e->getItem();

        $expectedTime = ceil($target->getBreakInfo()->getBreakTime($item) * 20);

        if($player->getEffects()->get(VanillaEffects::HASTE())){
            $expectedTime *= 1 - (0.2 * $player->getEffects()->get(VanillaEffects::HASTE())->getEffectLevel());
        }

        if($player->getEffects()->get(VanillaEffects::MINING_FATIGUE())){
            $expectedTime *= 1 + (0.3 * $player->getEffects()->get(VanillaEffects::MINING_FATIGUE())->getEffectLevel());
        }

        $expectedTime -= 1;

        $actualTime = ceil(microtime(true) * 20) - $this->breakTimes[$name];

        if($actualTime < $expectedTime){

            $e->cancel(true);

            if($this->counter[$name] >= 5) {
                $player->setGamemode(2);
                Main::getInstance()->getScheduler()->scheduleRepeatingTask(new GamemodeTask(4, $player), 20);
                foreach($this->plugin->getServer()->getOnlinePlayers() as $ops){
                    if($ops->hasPermission("NomenHC.helpop")){
                        if (isset(UserManager::$ac[$ops->getName()]))
                            $ops->sendMessage("§c§lANYCHEAT §r§7Gracz §c{$player->getName()} §7moze uzywac §cFASTBREAK");

                    }
                }
                Server::getInstance()->getLogger()->error("[ANTYCHEAT] §r§8(§7".$player->getName()."§8) §7 Prawdopodobnie korzysta z fastbreaka! §8(§4".$actualTime."§7/§4".$expectedTime."§8)");
                $this->counter[$name] = 0;

                return;
            }else
                $this->counter[$name]++;

            return;
        }

        $this->counter[$name]--;
        unset($this->breakTimes[$name]);
    }
    
    public function onPlayerQuit(PlayerQuitEvent $event){
        unset($this->breakTimes[$event->getPlayer()->getName()]);
        unset($this->counter[$event->getPlayer()->getName()]);
    }
}

