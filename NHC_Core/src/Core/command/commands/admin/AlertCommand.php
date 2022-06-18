<?php

declare(strict_types=1);

namespace Core\command\commands\admin;


use pocketmine\command\{
    Command, CommandSender
};

use Core\Main;
use Core\task\EntityTask;
use pocketmine\entity\Entity;
use Core\command\BaseCommand;
use Core\utils\Utils;
use pocketmine\entity\EntityIds;
use pocketmine\entity\Human;
use pocketmine\entity\Zombie;
use pocketmine\item\Item;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\player\Player;
use pocketmine\Server;
use Core\managers\BackupManager;

class AlertCommand extends BaseCommand {
    public function __construct() {
        parent::__construct("alert", "komenda alert", ["oglos"], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $player = $sender;
       if(empty($args)) {
            $sender->sendMessage(Main::format("Poprawne uzycie to §9/alert §8[§9wiadomosc§8]"));
        }
        if(isset($args[0])) {
            $msg = trim(implode(" ", $args));
            foreach($sender->getServer()->getOnlinePlayers() as $p){
                $p->sendTitle("§4§lAlert§r", "§c$msg", 0, 20*8, 0);
                $p->sendMessage("§4§lAlert§r§8 » §c$msg");
            }

        }
    }


}
