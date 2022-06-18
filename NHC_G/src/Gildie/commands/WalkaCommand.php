<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender, utils\CommandException};
use Gildie\Main;
use pocketmine\player\Player;

class WalkaCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("walka", "Komenda walka");
    }

    public function execute(CommandSender $sender, string $commandLabel, array $args) {
        if(!$this->canUse($sender))
            return;

        $guildManager = Main::getInstance()->getGuildManager();

        $nick = $sender->getName();

        if(!$sender instanceof Player) {
            $sender->sendMessage(Main::format("Tej komendy mozesz uzyc tylko w grze!"));
            return;
        }


        if(!$guildManager->isInGuild($nick)) {
            $sender->sendMessage(Main::format("Musisz byc w gildii aby uzyc tej komendy!"));
            return;
        }

        $guild = $guildManager->getPlayerGuild($sender->getName());

        if(($time = time() - $guild->getBattleTime()) < 180) {
            $sender->sendMessage(Main::format("Tej komendy mozesz uzyc za: §c".(180-$time)." §7sekund"));
            return;
        }

        $guild->setBattleTime();

        $sender->getServer()->broadcastMessage("§cGildia §l§4{$guild->getTag()} §r§czaprasza na §cwalke§7! \n§cJej kordy to X: {$guild->getHeartPosition()->getPosition()->getFloorX()} §r§cZ: §c{$guild->getHeartPosition()->getPosition()->getFloorZ()}");
    }
}