<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use Core\form\QuestForm;
use Core\user\User;

use pocketmine\command\{
    Command, CommandSender
};

use pocketmine\item\Item;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;

use Core\command\BaseCommand;

use pocketmine\player\Player;

use Core\Main;

class QuestCommand extends BaseCommand {
    public function __construct() {
        parent::__construct("quest", "komenda quest", ["zadania", "zadanie"], false);
    }

    public function onCommand(CommandSender $sender, array $args) : void {
        $sender->sendMessage(Main::format("Questy sa aktualnie §cwylaczone§8!"));

    }


}