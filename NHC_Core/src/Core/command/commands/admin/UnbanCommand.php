<?php

declare(strict_types=1);

namespace Core\command\commands\admin;

use Core\Main;
use Core\managers\WebhookManager;
use Core\user\UserManager;
use Core\util\FormatUtils;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\command\CommandSender;
use Core\command\BaseCommand;

class UnbanCommand extends BaseCommand {

    public function __construct() {
        parent::__construct("unban", "Komenda unban", [], false, true);
    }

    public function onCommand(CommandSender $sender, array $args) : void {

        if(!isset($args[0])) {
            $sender->sendMessage(FormatUtils::messageFormat("Poprawne uzycie: /unban §8[§9nick§8]"));
            return;
        }


        $api = Main::getInstance()->getBanAPI();

        if(!$api->isBanned($args[0])) {
            $sender->sendMessage(Main::format("Ten gracz nie jest zbanowany!"));
            return;
        }

        $api->unban($args[0]);

        $sender->sendMessage(Main::format("Pomyslnie odbanowano gracza §9$args[0]§7!"));


        $webhook = new Message();
        // $webhook->setContent("content message");
        //$webhook->setAvatar("logo.png");
        $webhook->setUserName("NomenHC | BANY");
        $data = date("Y");

        $embed = new Embed();
        $embed->setTitle("Gracz **__{$args[0]}__** zostal odbanowany!");
        $embed->addField("Odbanowany przez:", $sender->getName());
        $embed->setColor(0x00008B);
        $embed->setThumbnail("https://minotar.net/avatar/{$args[0]}.png");
        $webhook->setEmbed($embed);

        WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/914571114410311711/rY4CYaOWHA6682zioKVkx-xwwAOKyxlrSF5B9Lq0zqHgROiWUQy6ipObmwGFgLSM3Gre");

    }
}