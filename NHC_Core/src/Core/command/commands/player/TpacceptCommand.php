<?php

namespace Core\command\commands\player;

use Core\command\BaseCommand;
use pocketmine\player\Player;

use pocketmine\command\{
	Command, CommandSender
};

use pocketmine\item\Item;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;

use pocketmine\world\Position;

use Core\Main;

use Core\task\TpTask;

class TpacceptCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("tpaccept", "komenda tpaccept", ["akceptuj"], true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

		if(!$sender instanceof Player) {
			$sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
			return;
		}

	$nick = $sender->getName();

	if(empty($args)) {
	    if(empty(Main::$tp[$nick])) {
	        $sender->sendMessage("§r§8» §7Nikt nie wyslal do Ciebie prosby o teleportacje!");
	        return;
	    }

	    if(count(Main::$tp[$nick]) == 1) {
	        $player = $sender->getServer()->getPlayerExact(key(Main::$tp[$nick]));

	        $this->teleportProccess($sender, $player);
	    } else {
	        $sender->sendMessage("§r§8» §7Twoje prosby o teleportacje:§9 ");

	        $requests = [];

	        foreach(Main::$tp[$nick] as $p => $time)
	            $requests[] = $p;

	        $sender->sendMessage(Main::format(implode("§7, §9", $requests)));
	    }
	    return;
	}

	if($args[0] == "*") {
	    foreach(Main::$tp[$nick] as $player => $time) {
	        $player = $sender->getServer()->getPlayerExact($player);

	        $this->teleportProccess($sender, $player);
	    }
	} else {
	    $player = $sender->getServer()->getPlayerExact($args[0]);

	    if($player == null || !isset(Main::$tp[$nick][$player->getName()])) {
	        $sender->sendMessage("§r§8» §7Ten gracz nie wyslal do Ciebie porsby o teleportacje!");
	        return;
	    }

	    $this->teleportProccess($sender, $player);
	    }
	}

	private function teleportProccess(Player $player, Player $tp_player) {
	    $nick = $player->getName();
	    $tp_nick = $tp_player->getName();

        if($tp_player == null) return;
        if(!$tp_player->isOnline()) return;

	    if(time() - Main::$tp[$nick][$tp_nick] > 15) {
	        $player->sendMessage("§r§8» §cProsba o teleportacje wygasla!");
	        unset(Main::$tp[$nick][$tp_nick]);
	        return;
	    }

	    unset(Main::$tp[$nick][$tp_nick]);

	    $player->sendMessage("§r§8» §7Pomyslnie zaakceptowano prosbe o teleportacje gracza §9{$tp_nick}§7!");
	    $tp_player->sendMessage("§r§8» §7Gracz §9$nick §7zaakceptowal twoja porsbe o teleportacje!");

	    $time = 10;
	    $tp_player->addEffect(new EffectInstance(Effect::getEffect(9), 20*$time, 3));

        if(isset(Main::$tpTask[$tp_nick]))
            Main::$tpTask[$tp_nick]->cancel();

	    Main::$tpTask[$tp_nick] = Main::getInstance()->getScheduler()->scheduleDelayedTask(new TpTask($tp_player, Position::fromObject($player, $player->getWorld())), 20*$time);
	}
}