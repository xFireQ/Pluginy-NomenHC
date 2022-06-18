<?php

namespace Core\command\commands\admin;

use Core\command\BaseCommand;
use pocketmine\Server;

use pocketmine\command\{
	Command, CommandSender
};

use Core\managers\WebhookManager;
use Core\webhhok\Webhook;
use Core\webhook\types\Message;
use Core\webhook\types\Embed;

use Core\Main;

class TempbanCommand extends BaseCommand {

	public function __construct() {
        parent::__construct("tempban", "Komenda tempban", [], false, true);
	}

    public function onCommand(CommandSender $sender, array $args) : void {

		if(empty($args) || !isset($args[1])) {
			$sender->sendMessage(Main::format("Poprawne uzycie: /tempban §8[§9nick§8] [§9czas§8[§9h§8/§9m§8/§9s§8]§8] [§9powod§8]"));
			return;
		}

		$api = Main::getInstance()->getBanAPI();

		$player = Server::getInstance()->getPlayer($args[0]);

		$nick = $player == null ? $args[0] : $player->getName();

		if($api->isBanned($nick)) {
			$sender->sendMessage(Main::format("Ten gracz zostal juz zbanowany!"));
			return;
		}

		if(!strpos($args[1], "d") && !strpos($args[1], "h") && !strpos($args[1], "m") && !strpos($args[1], "s")){
			 $sender->sendMessage(Main::format("Nieprawidlowy format czasu!"));
 			return;
  }

  $time = 0;

 	if(strpos($args[1], "d"))
		$time = intval(explode("d", $args[1])[0]) * 86400;

 	if(strpos($args[1], "h"))
		$time = intval(explode("h", $args[1])[0]) * 3600;

		if(strpos($args[1], "m"))
		$time = intval(explode("h", $args[1])[0]) * 60;

		if(strpos($args[1], "s"))
		$time = intval(explode("s", $args[1])[0]);

		$reason = "";

		for($i = 2; $i <= count($args) - 1; $i++)
		 $reason .= $args[$i] . " ";

		if($reason == "") $reason = "BRAK";

		$api->setTempBan($nick, $reason, $sender->getName(), $time);

		if($player != null)
		 $player->kick($api->getBanMessage($player), false);

		$sender->sendMessage(Main::format("Pomyslnie zbanowano gracza §9$nick §7na czas §9$args[1] §7z powodem: §9$reason"));
				Server::getInstance()->broadcastMessage("§cGracz §4$nick §czostal zbanowany z powodem: §4$reason §cdlugosc: §4$time");

            $webhook = new Message();
            // $webhook->setContent("content message");
            //$webhook->setAvatar("logo.png");
            $webhook->setUserName("NomenHC | BANY");
        $time == null ? $date = "NIGDY" : $date = date("H:i:s, d.m.Y");
        $data = date("Y");



            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zostal zbanowany!");
            $embed->addField("Zbanowany przez:", $sender->getName());
            $embed->addField("Wygasa o:", "".$time);
            $embed->addField("Zostal zbanowany z powodem:", $reason);
            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

        WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/914571114410311711/rY4CYaOWHA6682zioKVkx-xwwAOKyxlrSF5B9Lq0zqHgROiWUQy6ipObmwGFgLSM3Gre");

        }
}