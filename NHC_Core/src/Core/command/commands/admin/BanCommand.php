<?php

namespace Core\command\commands\admin;

use Core\managers\WebhookManager;
use Core\user\UserManager;
use Core\Main;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use Core\command\BaseCommand;
//use Core\user\UserManager;
use pocketmine\Server;
use Core\util\FormatUtils;

class BanCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("ban", "Komenda ban", [], false, true);
	}

	public function onCommand(CommandSender $sender, array $args) : void {
        
        if(empty($args)) {
            $sender->sendMessage(Main::format("Poprawne uzycie: §9/ban §8[§9nick§8] [§9powod§8]"));
            return;
        }
        $api = Main::getInstance()->getBanAPI();

        $player = Server::getInstance()->getPlayer($args[0]);
        $nick = $player == null ? $args[0] : $player->getName();

        if($api->isBanned($nick)) {
            $sender->sendMessage(Main::format("Ten gracz zostal juz zbanowany!"));
            return;
        }

        array_shift($args);

        $reason = isset($args[0]) ? trim(implode(" ", $args)) : "BRAK";

        $api->setBan($nick, $reason, $sender->getName());

        if($player != null)
            $player->kick($api->getBanMessage($player), false);

        $sender->sendMessage(Main::format("Pomyslnie zbanowano gracza §9$nick §7z powodem: §9$reason"));

        Server::getInstance()->broadcastMessage("§cGracz §4$nick §czostal zbanowany, z powodem: §4$reason");


        $webhook = new Message();
        // $webhook->setContent("content message");
        //$webhook->setAvatar("logo.png");
        $webhook->setUserName("NomenHC | BANY");
        $data = date("Y");

        $embed = new Embed();
        $embed->setTitle("Gracz **__{$nick}__** zostal zbanowany!");
        $embed->addField("Zbanowany przez:", $sender->getName());
        $embed->addField("Wygasa:", "NIGDY :(");
        $embed->addField("Zostal zbanowany z powodem:", $reason);
        $embed->setColor(0x00008B);
        $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
        $webhook->setEmbed($embed);

        WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/914571114410311711/rY4CYaOWHA6682zioKVkx-xwwAOKyxlrSF5B9Lq0zqHgROiWUQy6ipObmwGFgLSM3Gre");


    }
}
