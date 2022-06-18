<?php

namespace Core\command\commands\admin;

use pocketmine\command\{
	Command, CommandSender
};

use Core\command\BaseCommand;
use Core\Main;
use Core\managers\WebhookManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;

class UnbanIpCommand extends BaseCommand {

	public function __construct() {
        parent::__construct("unban-ip", "Komenda unban-ip", [], false, true);
	}

    public function onCommand(CommandSender $sender, array $args) : void {
		if(empty($args)) {
			$sender->sendMessage(Main::format("Poprawne uzycie: /unban-ip §8[§9ip§8]"));
			return;
		}

		$api = Main::getInstance()->getBanAPI();

		if(!$api->isIpBanned($args[0])) {
			$sender->sendMessage(Main::format("To Ip nie jest zbanowane!"));
			return;
		}

		$api->unbanIp($args[0]);

		$sender->sendMessage(Main::format("Pomyslnie odbanowano IP §9$args[0]§7!"));


        $webhook = new Message();
        // $webhook->setContent("content message");
        //$webhook->setAvatar("logo.png");
        $webhook->setUserName("WaterPE | BANY");
        $data = date("Y");

        $embed = new Embed();
        $embed->setTitle("Gracz **__{$args[0]}__** zostal odbanowany!");
        $embed->addField("Odbanowany przez:", $sender->getName());
        $embed->setColor(0x00ccff);
        $embed->setThumbnail("https://minotar.net/avatar/{$args[0]}.png");
        $webhook->setEmbed($embed);

        WebhookManager::sendWebhook($webhook, "https://discord.com/api/webhooks/912034194048303135/ZMxiu6giCJyXdcHGMsVZhXw5akZ9upvBc9h0c-0ma9qLh2Ofq27YRd0sfnz3HJX3j6Qk");

    }
}
