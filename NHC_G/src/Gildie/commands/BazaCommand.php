<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender, utils\CommandException};
use Gildie\Main;
use Gildie\task\BazaTpTask;
use pocketmine\entity\Effect;
use pocketmine\entity\EffectInstance;
use pocketmine\player\Player;

class BazaCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("baza", "Komenda baza");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;

        //if(isset($args)) return;

        $guildManager = Main::getInstance()->getGuildManager();

        $nick = $sender->getName();

        if(!$sender instanceof Player) {
            $sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
            return;
        }


        if(!$guildManager->isInGuild($nick)) {
            $sender->sendMessage(Main::format("§7Musisz byc w gildii, aby uzyc tej komendy!"));
            return;
        }

        $guild = $guildManager->getPlayerGuild($nick);
        $time = 10;

        $api = $sender->getServer()->getPluginManager()->getPlugin("LightPE_Core");

        $sender->sendMessage(Main::format("Teleportacja nastapi za §910 §7sekund, nie ruszaj sie!"));

        $sender->addEffect(new EffectInstance(Effect::getEffect(9), 20*10, 3));

        if(!isset(Main::$bazaTask[$nick]))
            Main::$bazaTask[$nick] = Main::getInstance()->getScheduler()->scheduleDelayedTask(new BazaTpTask($sender, $guild->getBase()), 20*10);
    }
}