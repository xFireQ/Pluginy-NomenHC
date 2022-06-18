<?php

namespace Gildie;

use Core\listener\events\DataPacketReceiveListener;
use Gildie\fakeinventory\FakeInventory;
use Gildie\fakeinventory\SkarbiecInventory;
use Gildie\guild\GuildManager;
use Gildie\task\SetHeartTask;
use Gildie\task\UpdateSkarbiecTask;
use pocketmine\block\VanillaBlocks;
use pocketmine\event\entity\ExplosionPrimeEvent;
use pocketmine\event\Listener;

use pocketmine\event\server\DataPacketReceiveEvent;
use pocketmine\item\Item;
use pocketmine\item\ItemBlock;
use pocketmine\item\ItemIds;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\ContainerClosePacket;
use pocketmine\player\Player;

use pocketmine\block\Block;

use pocketmine\entity\Entity;

use pocketmine\event\player\{PlayerChatEvent, PlayerCommandPreprocessEvent, PlayerInteractEvent, PlayerMoveEvent};

use pocketmine\event\block\{
    BlockBreakEvent, BlockPlaceEvent
};

use pocketmine\event\entity\{
    EntityDamageEvent, EntityDamageByEntityEvent, EntityExplodeEvent
};
use Gildie\fakeinventory\inventory\PanelInventory;

use pocketmine\event\inventory\InventoryTransactionEvent;
use Gildie\fakeinventory\FakeInventoryManager;
use Gildie\bossbar\{
    Bossbar, BossbarManager
};
use Gildie\Main;
use pocketmine\scheduler\ClosureTask;
use pocketmine\Server;
use Core\api\NameTagsAPI;
use pocketmine\inventory\transaction\action\SlotChangeAction;

class EventListener implements Listener
{

    private $guildTerrain = [];
    private $primedExplode = [];

    public function onBreak(BlockBreakEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $x = $block->getPosition()->getFloorX();
        $y = $block->getPosition()->getFloorY();
        $z = $block->getPosition()->getFloorZ();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($player->hasPermission("NomenHC.guilds.op")) return;

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if(!$guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                $e->cancel(true);
                //$player->sendMessage(Main::format("Ten teren jest zajety przez gildie!"));
            } else {
                if(in_array($block->getId(), [\pocketmine\item\ItemIds::CHEST, \pocketmine\item\ItemIds::FURNACE, \pocketmine\item\ItemIds::BEACON]))
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_BLOCKS_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do niszczenia blokow"));
                }
            }
        }
    }

    public function ProtectGuildPlace(BlockPlaceEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $item = $e->getItem();

        $guildManager = Main::getInstance()->getGuildManager();

        $guild = $guildManager->getGuildFromPos($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ());
        if($guild == null) return;

        $heartPosition = $guild->getHeartPosition();
        $x = $heartPosition->getFloorX();
        $y = $heartPosition->getFloorY();
        $z = $heartPosition->getFloorZ();

        if(new Vector3($x, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x+1, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x+2, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x+3, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z+1) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z+2) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z+3) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z-1) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z-2) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z-3) == $block->getPosition()->asVector3() or

            new Vector3($x-1, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z) == $block->getPosition()->asVector3() or

            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z-1) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z-1) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z-1) == $block->getPosition()->asVector3() or

            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z-2) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z-2) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z-2) == $block->getPosition()->asVector3() or
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z-3) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z-3) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z-3) == $block->getPosition()->asVector3() or


            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x+1, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z-3) == $block->getPosition()->asVector3() or

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x+1, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z+3) == $block->getPosition()->asVector3() or

            ///EEEEA A E AE QE
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z+3) == $block->getPosition()->asVector3()
        ) {

            $e->cancel(true);
            $player->sendMessage("§l§4Uwaga!§r §cNie mozesz stawiac blokow na tym obszarze!");

        }

        if($player->hasPermission("NomenHC.guilds.op")) return;

        if($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if(!$guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                $e->cancel(true);
                //$player->sendMessage(Main::format("Ten teren jest zajety przez gildie!"));
            } else {

                $guild = $guildManager->getPlayerGuild($player->getName());

                if(isset($this->primedExplode[$guild->getTag()])) {
                    $time = time() - $this->primedExplode[$guild->getTag()];

                    if($time < 60) {
                        $e->cancel(true);
                        $player->sendMessage("§cNa terenie Twojej gildii wybuchlo §l§4TNT§r§c, §cnie mozesz budowac jeszcze przez §l§4".(60-$time)." §csekund!");
                    } else
                        unset($this->primedExplode[$guild->getTag()]);
                }

                if(in_array($block->getId(), [\pocketmine\item\ItemIds::TNT, \pocketmine\item\ItemIds::CHEST, \pocketmine\item\ItemIds::FURNACE, \pocketmine\item\ItemIds::BEACON]))
                    return;

                if(strpos($item->getName(), "Generator Kamienia"))
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_BLOCKS_PLACE)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do stawiania blokow"));
                }
            }
        }
    }

    public function WaterAndLava(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $item = $player->getInventory()->getItemInHand();

        $guildManager = Main::getInstance()->getGuildManager();

        if($player->hasPermission("NomenHC.guilds.op")) return;

        if($item->getId() !== \pocketmine\item\ItemIds::BUCKET)
            return;

        if($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if(!$guildManager->isInOwnPlot($player, $block->getPosition()->asVector3()))
                $e->cancel(true);
        }
    }

    public function Permission_TNTPlace(BlockPlaceEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::TNT)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_TNT_PLACE)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do stawiania TNT"));
                }
            }
        }
    }

    public function Permission_ChestPlace(BlockPlaceEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::CHEST)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_CHEST_PLACE_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do stawiania skrzynek"));
                }
            }
        }
    }

    public function Permission_ChestBreak(BlockBreakEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::CHEST)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_CHEST_PLACE_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do niszczenia skrzynek"));
                }
            }
        }
    }

    public function Permission_ChestOpen(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != ItemIds::CHEST)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_CHEST_OPEN)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do otwierania skrzynek"));
                }
            }
        }
    }

    public function Permission_FurnacePlace(BlockPlaceEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::FURNACE)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_FURNACE_PLACE_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do stawiania piecy"));
                }
            }
        }
    }

    public function Permission_FurnaceBreak(BlockBreakEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::FURNACE)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_FURNACE_PLACE_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do niszczenia piecy"));
                }
            }
        }
    }

    public function Permission_FurnaceOpen(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::FURNACE)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_FURNACE_OPEN)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do otwierania piecy"));
                }
            }
        }
    }

    public function tpaccept(PlayerCommandPreprocessEvent $e) {
        $player = $e->getPlayer();

        $guildManager = Main::getInstance()->getGuildManager();

        if($e->getMessage()[0] == "/") {
            $cmd = explode(" ", $e->getMessage())[0];

            if($cmd !== "/tpaccept")
                return;

            if ($guildManager->isPlot($player->getPosition()->getFloorX(), $player->getPosition()->getFloorZ())) {
                if ($guildManager->isInOwnPlot($player, $player)) {

                    if (!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_TPACCEPT)) {
                        $e->cancel(true);
                        $player->sendMessage(Main::format("§7Nie masz permisji do akceptowania teleportacji innych na terenie gildii"));
                    }
                }
            }
        }
    }

    public function setHomes(PlayerCommandPreprocessEvent $e) {
        $player = $e->getPlayer();

        $guildManager = Main::getInstance()->getGuildManager();

        if($e->getMessage()[0] == "/") {
            $cmd = explode(" ", $e->getMessage())[0];

            if($cmd !== "/sethome")
                return;

            if($guildManager->isPlot($player->getPosition()->getFloorX(), $player->getPosition()->getFloorZ())) {
                if(!$guildManager->isInOwnPlot($player, $player)) {
                    $e->cancel(true);
                    $player->sendMessage("§8» §cNie mozesz zakladac home'ów na terenie cudzej gildii!");
                }
            }
        }
    }

    public function Permission_Lava(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $item = $player->getInventory()->getItemInHand();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if(!($item->getId() == 325 && $item->getMeta() == 10))
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_LAVA)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do wylewania lawy"));
                }
            }
        }
    }

    public function Permission_Water(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $item = $player->getInventory()->getItemInHand();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if(!($item->getId() == 325 && $item->getMeta() == 8))
                    return;

                if(in_array($block->getId(), [\pocketmine\item\ItemIds::LEVER, \pocketmine\item\ItemIds::WOODEN_BUTTON, \pocketmine\item\ItemIds::STONE_BUTTON]))
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_WATER)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do wylewania wody"));
                }
            }
        }
    }

    public function Permission_Interact(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $item = $player->getInventory()->getItemInHand();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {

                if(!in_array($block->getId(), [\pocketmine\item\ItemIds::LEVER, \pocketmine\item\ItemIds::WOODEN_BUTTON, \pocketmine\item\ItemIds::STONE_BUTTON]))
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_INTERACT)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do intreakcji"));
                }
            }
        }
    }

    public function Permission_BeaconPlace(BlockPlaceEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::BEACON)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_BEACON_PLACE_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do stawiania beaconow"));
                }
            }
        }
    }

    public function Permission_BeaconBreak(BlockBreakEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::BEACON)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_BEACON_PLACE_BREAK)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do niszczenia beaconow"));
                }
            }
        }
    }

    public function Permission_BeaconOpen(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if ($guildManager->isPlot($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ())) {
            if($guildManager->isInOwnPlot($player, $block->getPosition()->asVector3())) {
                if($block->getId() != \pocketmine\item\ItemIds::BEACON)
                    return;

                if(!$guildManager->hasPermission($player->getName(), GuildManager::PERMISSION_BEACON_OPEN)) {
                    $e->cancel(true);
                    $player->sendMessage(Main::format("§7Nie masz permisji do otwierania beaconow"));
                }
            }
        }
    }

    public function onEntityDamage(EntityDamageEvent $e)
    {
        if ($e instanceof EntityDamageByEntityEvent) {
            $entity = $e->getEntity();
            $damager = $e->getMetar();

            $guildManager = Main::getInstance()->getGuildManager();

            if($entity instanceof Player && $damager instanceof Player) {
                //   Main::getInstance()->getGuildManager()->updateNameTags();
            }

            if ($entity instanceof Player && $damager instanceof Player && $entity->getName() !== $damager->getName()) {
                // Main::getInstance()->getGuildManager()->updateNameTags();
                if ($guildManager->isInGuild($entity->getName()) && $guildManager->isInGuild($damager->getName())) {
                    if ($guildManager->isInSameGuild($entity, $damager)) {
                        if (!$guildManager->getPlayerGuild($damager->getName())->isGuildPvP())
                            $e->cancel(true);
                    } elseif ($guildManager->getPlayerGuild($entity->getName())->hasAllianceWith($guildManager->getPlayerGuild($damager->getName()))) {
                        if (!$guildManager->getPlayerGuild($damager->getName())->isAlliancesPvP())
                            $e->cancel(true);
                    }
                }
            }
        }
    }

    public function HeartProtect(BlockBreakEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();
        $guild = $guildManager->getGuildFromPos($block->getPosition()->getFloorX(), $block->getPosition()->getFloorZ());
        if($guild == null) return;

        $heartPosition = $guild->getHeartPosition();
        $x = $heartPosition->getFloorX();
        $y = $heartPosition->getFloorY();
        $z = $heartPosition->getFloorZ();

        if(new Vector3($x, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x+1, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x+2, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x+3, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z+1) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z+2) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z+3) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z-1) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z-2) == $block->getPosition()->asVector3() or

            new Vector3($x, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x, $y-2, $z-3) == $block->getPosition()->asVector3() or

            new Vector3($x-1, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z) == $block->getPosition()->asVector3() or

            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z-1) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z-1) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z-1) == $block->getPosition()->asVector3() or

            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z-2) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z-2) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z-2) == $block->getPosition()->asVector3() or
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z-3) == $block->getPosition()->asVector3() or

            new Vector3($x-2, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z-3) == $block->getPosition()->asVector3() or

            new Vector3($x-3, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z-3) == $block->getPosition()->asVector3() or


            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x+1, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z-1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z-2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z-3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z-3) == $block->getPosition()->asVector3() or

            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x+1, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+1, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+2, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x+3, $y-2, $z+3) == $block->getPosition()->asVector3() or

            ///EEEEA A E AE QE
            ////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

            //@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            //EEEEEEEEEEEEEEEEEEEEEEEEEEEEE
            new Vector3($x-1, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z+1) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z+2) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-1, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-2, $y-2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y+2, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-1, $z+3) == $block->getPosition()->asVector3() or
            new Vector3($x-3, $y-2, $z+3) == $block->getPosition()->asVector3()
        ) {

            $e->cancel(true);
            $player->sendMessage("§l§4Uwaga!§r §cNie mozesz niszczyc dizajnu gildii!");

        }



        if($guildManager->isHeart($block)) {
            $e->cancel(true);

            $player->sendMessage("§l§4Uwaga!§r §cNie mozesz niszczyc serca gildi!");
        }
    }

    public function HeartExplodeProtect(EntityExplodeEvent $e) {
        foreach($e->getBlockList() as $block) {
            if(Main::getInstance()->getGuildManager()->isHeart($block))
                Main::getInstance()->getScheduler()->scheduleDelayedTask(new SetHeartTask($block), 5);
        }
    }

    public function BlockBlocksPlaceOnPrimeExplode(ExplosionPrimeEvent $e) {
        $entity = $e->getEntity();

        $guildManager = Main::getInstance()->getGuildManager();

        if($guildManager->isPlot($entity->getPosition()->getFloorX(), $entity->getPosition()->getFloorZ())) {
            $guild = $guildManager->getGuildFromPos($entity->getPosition()->getFloorX(), $entity->getPosition()->getFloorZ());
            $this->primedExplode[$guild->getTag()] = time();

            foreach($guild->getPlayers() as $nick) {
                $player = Server::getInstance()->getPlayerExact($nick);

                if($player)
                    $player->sendMessage("§cNa terenie Twojej gildii wybuchlo §4TNT§c, §cnie mozesz budowac jeszcze przez §460 §csekund!");
                //$e->cancel();
            }
        }
    }


    public function onConquer(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();

        $guildManager = Main::getInstance()->getGuildManager();

        if($guildManager->isHeart($block)) {
            if(!$guildManager->isInGuild($player->getName())) {
                //$player->sendMessage("§8» Musisz byc w gildii aby podbic inna gildie!");
                $player->sendTitle("§l§4OCHRONA", "§r§cMusisz byc w Gildi aby podbic inna gildie");
                return;
            }

            $guild = $guildManager->getGuildFromHeart($block->getPosition()->asVector3());
            $pGuild = $guildManager->getPlayerGuild($player->getName());

            if($pGuild === $guild) {
                if($e->getAction() == $e::RIGHT_CLICK_BLOCK && $e->getItem() instanceof ItemBlock)
                    return;

                $e->cancel(true);
                //$player->sendMessage(Main::format("Nie mozesz podbic swojej gildii!"));
                $gui = new PanelInventory($player);
                $gui->setItems($player);
                $gui->openFor([$player]);
            } else {
                if(!$guild->canConquer()) {
                    $conquerTime = strtotime($guild->getConquerDate()) - time();

                    $conquerH = floor($conquerTime / 3600);
                    $conquerM = floor(($conquerTime / 60) % 60);
                    $conquerS = $conquerTime % 60;

                    $player->sendMessage("§cTa gildie mozna podbic za: §c$conquerH §cgodzin, §c$conquerM minut i §c$conquerS sekund");
                } else {
                    $guild->setLifes($guild->getLifes() - 1);

                    if($guild->getLifes() <= 0) {
                        $player->getServer()->broadcastMessage(Main::format("Gildia §9{$pGuild->getTag()} §r§7odebrala ostatnie serce gildii §9{$guild->getTag()}"));
                        $guild->remove($player->getWorld());
                    } else {
                        $player->getServer()->broadcastMessage(Main::format("Gildia §9{$pGuild->getTag()} §r§7odebrala §91 §7serce gildii §9{$guild->getTag()}"));

                        $date = date_create(date("H:i:s", time()));
                        date_add($date,date_interval_create_from_date_string("1 days"));
                        $guild->setConquerDate(date_format($date,"d.m.Y H:i:s"));
                    }
                }
            }
        }
    }

    public function guildChat(PlayerChatEvent $e) {
        $player = $e->getPlayer();
        $msg = $e->getMessage();

        $guildManager = Main::getInstance()->getGuildManager();

        if($guildManager->isInGuild($player->getName())) {
            if(!isset($msg[1]))
                return;

            if($msg[0] == "!" && $msg[1] != "!") {
                $msg = substr($msg, 1);
                $e->cancel(true);
                $guildManager->getPlayerGuild($player->getName())->messageToMembers("§8[§aGILDIA§8] §7{$player->getName()}: §a$msg");
            }
        }
    }

    public function allaincesChat(PlayerChatEvent $e) {
        $player = $e->getPlayer();
        $msg = $e->getMessage();

        $guildManager = Main::getInstance()->getGuildManager();

        if($guildManager->isInGuild($player->getName())) {
            if(!isset($msg[2]))
                return;

            if($msg[0] == "!" && $msg[1] == "!") {
                $e->cancel(true);

                $guild = $guildManager->getPlayerGuild($player->getName());

                $msg = substr($msg, 2);
                $message = "§8[§6{$guild->getTag()}§8] §7{$player->getName()}: §6$msg";

                $guild->messageToMembers($message);

                foreach($guild->getAlliances() as $tag) {
                    $guildManager->getGuildByTag($tag)->messageToMembers($message);
                }
            }
        }
    }

    public function needHelp(PlayerChatEvent $e) {
        $player = $e->getPlayer();
        $msg = $e->getMessage();

        $guildManager = Main::getInstance()->getGuildManager();

        if($guildManager->isInGuild($player->getName())) {
            if($msg == "#") {
                $e->cancel(true);
                $guildManager->getPlayerGuild($player->getName())->messageToMembers("§7Gracz §9{$player->getName()} §r§7potrzebuje pomocy! \n§7Kordy to X: §9{$player->getPosition()->getFloorX()} §r§7Y: §9{$player->getPosition()->getFloorY()} §r§7Z: §9{$player->getPosition()->getFloorZ()}");
            }
        }
    }

    public function BazaTpMoveCancel(PlayerMoveEvent $e) {
        $player = $e->getPlayer();
        $nick = $player->getName();

        if(isset(Main::$bazaTask[$nick])) {
            if(!($e->getTo()->floor()->equals($e->getFrom()->floor()))) {
                Main::$bazaTask[$nick]->cancel();
                unset(Main::$bazaTask[$nick]);
                $player->sendMessage("§8» §cTeleportacja do bazy gildii zostala przerwana!");
                $player->removeEffect(9);
            }
        }
    }

    public function BossbarAndMessage(PlayerMoveEvent $e) {
        if($e->getFrom()->floor()->equals($e->getTo()->floor()))
            return;

        $player = $e->getPlayer();
        $x = $player->getPosition()->getFloorX();
        $z = $player->getPosition()->getFloorZ();
        $nick = $player->getName();

        $ownTitle = "§8» §7Jestes na terenie swojej gildi §8[§a{TAG}§8]";
        $enemyTitle = "§8» §7Jestes na terenie wrogiej gildi §8[§c{TAG}§8] §8- [§c{NAME}§8] ";

        $bossbar = BossbarManager::getBossbar($player);
        $guildManager = Main::getInstance()->getGuildManager();

        if($guildManager->isPlot($x, $z)) {
            if($bossbar == null) {
                $bossbar = new Bossbar("");
                $bossbar->showTo($player);
            }

            $guild = $guildManager->getGuildFromPos($x, $z);
            $tag = $guild->getTag();
            $name = $guild->getName();

            if($guildManager->isInOwnPlot($player, $player->getPosition()->asVector3())) {
                $title = str_replace("{TAG}", $tag, $ownTitle);
                if($bossbar->getTitle() != $title)
                    $bossbar->setTitle($title);

                if(!isset($this->guildTerrain[$nick])) {
                    $this->guildTerrain[$nick] = [$tag, $name];
                    // $player->sendMessage(Main::format("§7Wkroczyles na teren swojej gildii"));
                    $player->sendTitle("§l§9GILDIE", "§7Wkroczyles na teren gildi §8[§a{$tag}§8]");
                }
            } else {
                $title = str_replace("{TAG}", $tag, $enemyTitle);
                $title = str_replace("{NAME}", $name, $title);
                if($bossbar->getTitle() != $title)
                    $bossbar->setTitle($title);

                if(!isset($this->guildTerrain[$nick])) {
                    $this->guildTerrain[$nick] = [$tag, $name];
                    // $player->sendMessage(Main::format("§7Wkroczyles na teren gildii §8[§c{$tag}§8] §8- §c{$name}"));
                    $player->sendTitle("§l§9GILDIE", "§7Wkroczyles na teren gildi §8[§c{$tag}§8] - [§c{$name}§8]");

                    if($player->hasPermission("NomenHC.guilds.op"))
                        return;

                    foreach($guild->getPlayers() as $nick) {
                        $p = $player->getServer()->getPlayerExact($nick);

                        if($p) {
                            $p->sendMessage("§8» §cGracz §c{$player->getName()} wkroczyl na teren Twojej gildi!");
                            $p->sendTitle("§l§4INTRUZ", "§r§cIntruz wkroczyl na teren Gildi!");
                        } else {
                            //Tu Coz
                        }
                    }
                }
            }
        } else {
            if($bossbar != null)
                $bossbar->hideFrom($player);

            if(isset($this->guildTerrain[$nick])) {
                $tag = $this->guildTerrain[$nick][0];
                $name = $this->guildTerrain[$nick][1];
                unset($this->guildTerrain[$nick]);

                $guild = $guildManager->getPlayerGuild($nick);

                if($guild != null && $guild->getTag() == $tag) {
                    //  $player->sendMessage(Main::format("§7Opusciles teren swojej gildii"));
                    $player->sendTitle("§l§9GILDIE", "§7Opusciles teren gildi §8[§a{$tag}§8]");
                } else {
                    // $player->sendMessage(Main::format("§7Opusciles teren gildii §8[§c{$tag}§8] §8- §c{$name}"));
                    $player->sendTitle("§l§9GILDIE", "§7Opusciles teren gildi §8[§c{$tag}§8]");
                }
            }
        }
    }

    /**
     * @param DataPacketReceiveEvent $e
     * @ignoreCancelled true
     */
    public function fakeInventory(DataPacketReceiveEvent $e) : void {
        $player = $e->getOrigin()->getPlayer();
        $packet = $e->getPacket();

        if($packet instanceof ContainerClosePacket) {
            if(($fakeInventory = Main::getInstance()->getFakeInventoryManager()->getInventory($player->getName())) !== null) {
                Main::getInstance()->getScheduler()->scheduleTask(new ClosureTask(function() use ($player, $fakeInventory) : void {
                    if($fakeInventory->hasChanged() && $fakeInventory->isClosed()) {
                        $fakeInventory->nextInventory->openFor([$player]);
                    }
                }));
            }
        }
    }

    /**
     * @param InventoryTransactionEvent $e
     * @priority NORMAL
     * @ignoreCancelled true
     */

    public function onTransaction(InventoryTransactionEvent $e) : void {
        $transaction = $e->getTransaction();
        $player = $transaction->getSource();
        $inventories = $transaction->getInventories();
        $actions = $transaction->getActions();

        $fakeInventory = Main::getInstance()->getFakeInventoryManager()->getInventory($player->getName());

        foreach($inventories as $inventory) {
            if($inventory instanceof FakeInventory) {
                if($fakeInventory === null) {
                    $e->cancel();
                    return;
                }

                foreach($actions as $action) {
                    if(!$action instanceof SlotChangeAction || $action->getInventory() !== $inventory)
                        continue;

                    $fakeInventory->onTransaction($player, $action->getSourceItem(), $action->getTargetItem(), $action->getSlot()) ? $e->cancel() : $e->uncancel();
                }
            }
        }
    }


}