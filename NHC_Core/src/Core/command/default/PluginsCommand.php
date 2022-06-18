<?php

declare(strict_types=1);

namespace Core\command\default;

use Core\format\Permission;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Core\util\ConfigUtil;
use Core\form\SettingsForm;
use Core\deposit\DepositManager;
use pocketmine\player\Player;
use pocketmine\Server;
use pocketmine\lang\TranslationContainer;
use pocketmine\plugin\Plugin;
use pocketmine\utils\TextFormat;

class PluginsCommand extends Command {
    public function __construct() {
        parent::__construct("plugins", "komenda plugins", null, ["pl", "plg"]);
    }

    public function execute(CommandSender $sender, String $label, array $args): void {
        if(!Permission::isOp($sender)) {
            $sender->sendMessage(ConfigUtil::getMessage("messages.permissions", false));
            return;
        }
        $list = array_map(function(Plugin $plugin) : string{
            return ($plugin->isEnabled() ? TextFormat::BLUE : TextFormat::RED) . $plugin->getDescription()->getFullName();
        }, $sender->getServer()->getPluginManager()->getPlugins());
        sort($list, SORT_STRING);
        $message = ConfigUtil::getMessage("commands.plugins", false);
        $message = str_replace("{COUNT}", "".count($list), $message);
        $message = str_replace("{LIST}", "".implode(", ", $list), $message);

        $sender->sendMessage($message);

    }
}
