<?php

namespace Core\command\commands\admin;

use Core\command\BaseCommand;
use Core\managers\WebhookManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};

use Core\Main;

class BanIpCommand extends BaseCommand {

	public function __construct() {
		parent::__construct("ban-ip", "Komenda ban-ip", [], false, true);
	}

    public function onCommand(CommandSender $sender, array $args) : void {
		if(empty($args)) {
			$sender->sendMessage(Main::format("Poprawne uzycie: /ban-ip §8[§9nick§8] [§9powod§8]"));
			return;
		}

		$api = Main::getInstance()->getBanAPI();

		$player = Server::getInstance()->getPlayer($args[0]);

		if($player == null) {
			$sender->sendMessage(Main::format("Ten gracz jest §9offline"));
			return;
		}

		$ip = $player->getAddress();

		if($api->isIpBanned($ip)) {
			$sender->sendMessage(Main::format("To IP zostalo juz zbanowane!"));
			return;
		}

		array_shift($args);

		$reason = isset($args[0]) ? trim(implode(" ", $args)) : "BRAK";

		$api->setIpBan($reason, $sender->getName(), $ip);

		foreach(Server::getInstance()->getOnlinePlayers() as $p) {
			if($p->getAddress() == $ip)
			 $p->kick($api->getBanMessage($p), false);
		}

		$sender->sendMessage(Main::format("Pomyslnie zbanowano gracza §9{$player->getName()} §7na IP z powodem: §9$reason"));


        $webhook = new Message();
        // $webhook->setContent("content message");
        //$webhook->setAvatar("logo.png");
        $webhook->setUserName("NomenHC | BANY");
        $data = date("Y");

        $embed = new Embed();
        $embed->setTitle("Gracz **__{$player->getName()}__** zostal zbanowany na IP!");
        $embed->addField("Zbanowany przez:", $sender->getName());
        $embed->addField("Wygasa:", "NIGDY");
        $embed->addField("Zostal zbanowany z powodem:", $reason);
        $embed->setColor(0x00008B);
        $embed->setThumbnail("https://minotar.net/avatar/{$player->getName()}.png");
        $webhook->setEmbed($embed);

        WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/914571114410311711/rY4CYaOWHA6682zioKVkx-xwwAOKyxlrSF5B9Lq0zqHgROiWUQy6ipObmwGFgLSM3Gre");

    }
}