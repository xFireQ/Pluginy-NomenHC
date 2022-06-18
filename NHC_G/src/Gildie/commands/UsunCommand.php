<?php

namespace Gildie\commands;

use pocketmine\command\{Command, CommandSender};
use Gildie\Main;
use pocketmine\player\Player;

class UsunCommand extends GuildCommand {

    public function __construct() {
        parent::__construct("usun", "Komenda usun");
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
            $sender->sendMessage(Main::format("§7Musisz byc w gildii aby uzyc tej komendy!"));
            return;
        }

        $guild = $guildManager->getPlayerGuild($nick);

        if($guild->getPlayerRank($nick) !== "Leader") {
            $sender->sendMessage(Main::format("§7Musisz byc liderem gildii aby to zrobic!"));
            return;
        }

        $sender->getServer()->broadcastMessage(Main::format("Gracz §9$nick §7usunal gildie §8[§9§l{$guild->getTag()}§r§8] - §8[§l§9{$guild->getName()}§r§8]"));

        $guild->remove($sender->getWorld());
    }
}