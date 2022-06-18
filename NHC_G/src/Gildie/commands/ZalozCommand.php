<?php

namespace Gildie\commands;

use pocketmine\command\{
    Command, CommandSender
};
use Gildie\utils\ShapesUtils;
use pocketmine\block\Block;
use pocketmine\block\VanillaBlocks;
use pocketmine\item\Item;
use pocketmine\level\Level;
use pocketmine\level\particle\DustParticle;
use pocketmine\level\particle\SmokeParticle;
use pocketmine\math\Vector3;
use pocketmine\world\Position;
use pocketmine\network\mcpe\protocol\ActorEventPacket;
use pocketmine\network\mcpe\protocol\LevelEventPacket;
use pocketmine\player\Player;
use Gildie\Main;
use Core\Main as CoreMain;
use Gildie\guild\GuildManager;

class ZalozCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("zaloz", "Komenda zaloz");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) : void {
        if(!$this->canUse($sender))
            return;
            $leader = $sender;
    	$nick = $sender->getName();

        if(!$sender instanceof Player) {
            $sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
            return;
        }

        $guildManager = Main::getInstance()->getGuildManager();

        if(!isset($args[1])) {
            $sender->sendMessage(Main::format("Poprawne uzycie: /zaloz (tag) (nazwa)"));
            return;
        }

        if($guildManager->isInGuild($sender->getName())) {
            $sender->sendMessage(Main::format("Jestes juz w gildii!"));
            return;
        }

        $border = floor(1200 / 2);

        $x = $sender->getPosition()->getFloorX();
        $z = $sender->getPosition()->getFloorZ();
        if($x >= $border || $x <= -$border || $z >= $border || $z <= -$border) {
            $sender->sendMessage(Main::format("Nie mozesz zalozyc gildii za borderem mapy!"));
            return;
        }

        $lvl = 0;

        
         /*foreach(GuildManager::getItems($sender) as $item){
             
             if(!$sender->getInventory()->contains($item)){
                    $sender->sendMessage(Main::format("Nie posiadasz wszystkich itemow na gildie!"));
                    return;
                }
          

            $lvl = 50;

          		if($sender->hasPermission("NomenHC.gildie.vip"))
	          	 $lvl = 40;
		 
	          	if($sender->hasPermission("NomenHC.gildie.svip"))
		           $lvl = 30;
		
		          if($sender->hasPermission("NomenHC.gildie.sponsor"))
		           $lvl = 20;

            if($sender->getXpManager()->getXpLevel() < $lvl) {
                $sender->sendMessage(Main::format("Nie posiadasz wymaganago poziomu doswiadczenia ( $lvl ) !"));
                return;
            }
         }*/
        

        if(strlen($args[0]) > 5) {
            $sender->sendMessage(Main::format("§7Tag gildii jest za dlugi! Moze wynosic max §95 §7znakow"));
            return;
        }
        
        if(strlen($args[0]) < 2) {
            $sender->sendMessage(Main::format("§7Tag gildii jest za krotki! Musi wynosic minimum §92 §7znaki"));
            return;
        }

        if(!ctype_alnum($args[0])) {
            $sender->sendMessage(Main::format("§7Tag gildii moze zawierac tylko litery i cyfry"));
            return;
        }
        
        if(strlen($args[1]) < 5) {
            $sender->sendMessage(Main::format("Nazwa gildii jest za krotka! musi wynosic§9 minimum 5 §7znakow"));
            return;
        }

        if(strlen($args[1]) > 30) {
            $sender->sendMessage(Main::format("Nazwa gildii jest za dlugi! moze wynosic max §930 §7znakow"));
            return;
        }

        if($guildManager->isGuildExists($args[0])) {
            $sender->sendMessage(Main::format("§7Ta gildia juz istnieje!"));
            return;
        }

        if($sender->getPosition()->distance($sender->getWorld()->getSafeSpawn()) < 270) {
            $sender->sendMessage(Main::format("§7Gildie mozna zakladac §9270 kratek od spawnu"));
            return;
        }

        $maxSize = 80;

        $x = $sender->getPosition()->getFloorX();
        $z = $sender->getPosition()->getFloorZ();

        $arm = floor($maxSize / 2);

        $max_x1 = $x + $arm;
        $max_z1 = $z + $arm;
        $max_x2 = $x - $arm;
        $max_z2 = $z - $arm;

        if($guildManager->isMaxPlot($max_x1, $max_z1) || $guildManager->isMaxPlot($max_x2, $max_z2) || $guildManager->isMaxPlot($max_x2, $max_z1) || $guildManager->isMaxPlot($max_x1, $max_z2)) {
            $sender->sendMessage(Main::format("§7Jestes zbyt blisko innej gildii!"));
            return;
        }


        $sender->getServer()->broadcastMessage(Main::format("Gilia §8[§9§l$args[0]§r§8] - §8[§9§l$args[1]§r§8] §7zostala zalozona przez gracza §9{$sender->getName()}"));

        Main::getInstance()->getDb()->query("INSERT INTO players (player, guild, rank) VALUES ('{$sender->getName()}', '$args[0]', 'Leader')");

        $defaultSize = 80;

        $arm = floor($defaultSize / 2);

        $x1 = $x + $arm;
        $z1 = $z + $arm;
        $x2 = $x - $arm;
        $z2 = $z - $arm;

        Main::getInstance()->getDb()->query("INSERT INTO plots (guild, size, x1, z1, x2, z2, max_x1, max_z1, max_x2, max_z2) VALUES ('$args[0]', '$defaultSize', '$x1', '$z1', '$x2', '$z2', '$max_x1', '$max_z1', '$max_x2', '$max_z2')");

        $date = date_create(date("G:i:s"));
        date_add($date,date_interval_create_from_date_string("3 days"));
        $date =  date_format($date,"d.m.Y H:i:s");

        Main::getInstance()->getDb()->query("INSERT INTO guilds (guild, name, lifes, base_x, base_y, base_z, heart_x, heart_y, heart_z, conquer_date, expiry_date, pvp_guild, pvp_alliances) VALUES ('$args[0]', '$args[1]', '3', '{$sender->getPosition()->getX()}', '32', '{$sender->getPosition()->getZ()}', '{$sender->getPosition()->getFloorX()}', '31', '{$sender->getPosition()->getFloorZ()}', '$date', '$date', 'off', 'off')");

       // $heartPosition = new Position($sender->getPosition()->getFloorX(), 31, $sender->getPosition()->getFloorZ(), $sender->getWorld());

        ////$sender->teleport($heartPosition->add(0, 1));

      // / //ShapesUtils::createGuildShape($heartPosition);

        //$sender->getWorld()->setBlock($heartPosition, BlockFactory::getInstance()->get(\pocketmine\item\ItemIds::END_PORTAL_FRAME));
        
        $heartPosition = new \pocketmine\world\Position($sender->getPosition()->getFloorX(), 31, $sender->getPosition()->getFloorZ(), $sender->getWorld());
        
        $heartPosition = new Position($leader->getPosition()->getFloorX(), 31, $leader->getPosition()->getFloorZ(), $leader->getWorld());
        
        $fakeHeartPosition = new Position($leader->getPosition()->getFloorX(), 30, $leader->getPosition()->getFloorZ(), $leader->getWorld());
        ShapesUtils::createGuildShape($fakeHeartPosition);
        
        $leader->teleport($fakeHeartPosition->asPosition()->add(0, 1, 0));

        
        
        $leader->getWorld()->setBlock(new Vector3($x, 30, $z), VanillaBlocks::COBBLESTONE_WALL());

        $leader->getWorld()->setBlock(new Vector3($x, 32, $z), VanillaBlocks::COBBLESTONE_WALL());

        $leader->getWorld()->setBlock($heartPosition, VanillaBlocks::MONSTER_SPAWNER());
       // $sender->getWorld()->addParticle();
        $guildManager->setAllPermissions($nick);

        $guildManager->updateNameTags();

        
            /*foreach(GuildManager::getItems($sender) as $item) {
               $sender->getInventory()->removeItem($item);
            }*/
          //  $sender->setXpLevel($sender->getXpLevel() - $lvl);
    }
            	
}