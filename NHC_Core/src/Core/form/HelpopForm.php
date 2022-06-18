<?php

namespace Core\form;

use pocketmine\world\Position;
use pocketmine\player\Player;
use Core\utils\Utils;
use Core\settings\SettingsManager;
use Core\Main;
use pocketmine\Server;
use Core\managers\WebhookManager;

use Core\webhhok\Webhook;
use Core\webhook\types\Message;
use Core\webhook\types\Embed;

class HelpopForm extends Form {

    private static $reports = ['Cheaty', 'Wyzywanie', 'Reklamowanie', 'Bugowanie', 'Podszywanie', 'Mam blad', 'Inne'];

    public function __construct(Player $player) {




        $data = [
            "type" => "custom_form",
            "title" => "§r§9§lHELPOP",
            "content" => []
        ];

        $players = [];
        foreach (Server::getInstance()->getOnlinePlayers() as $p) {
            if ($p->getName() == $player->getName()) continue;
            $players[] = $p->getName();
        }

        //$data["content"][] = ["type" => "label", "text" => "§7Wyslij zgloszenie"];



        $data["content"][] = ["type" => "dropdown", "text" => "§7Powod zgloszenia\n", "options" => self::$reports];
        $data["content"][] = ["type" => "input", "text" => "§7Osoba ktora chcesz zglosic\n"];
        $data["content"][] = ["type" => "input", "text" => "§7Podaj dodatkowe informacje §cWYMAGANE\n"];







        $this->data = $data;
    }

    public function handleResponse(Player $player, $data) : void {
        $nick = $player->getName();

        if ($data === null // player clicks the x button
            or $data[0] === "" // player submit an empty text
        ) {

            return;
        }
        if($data[1]) {
            if($data[2]) {
                foreach (Server::getInstance()->getOnlinePlayers() as $players) {
                    if ($players->hasPermission("NomenHC.helpop")) {
                        $players->sendMessage("§8[§f{$data[0]}§8] §9$nick §fzglasza §9{$data[1]}§f: §e{$data[2]}");
                    }
                }
                $webhook = new Message();
                $webhook->setUserName("NomenHC | HELPOP");
                $embed = new Embed();
                $embed->setTitle("HELPOP");
                $embed->setColor(0xffa500);
                $embed->setFooter("Footer");
                $embed->addField("Nick zgloszonego", $data[1]);
                $embed->addField("Wiadomosc", $data[2]);
                $embed->addField("ID", $data[0]);
                $embed->addField("Nick zglaszajacego", $nick);
                $embed->setThumbnail("https://minotar.net/avatar/{$player->getName()}.png");
                $webhook->setEmbed($embed);

                WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940246599991443596/oA798tMP2K0OSUGuYAE_IGFn_NF4MzFFSQSjsPllzV9cEbgmz3t0uJmFygLu7c5shb8D");


                $player->sendMessage(Main::format("Pomyslnie wyslano zgloszenie o id §f{$data[0]}"));
            } else {
                $player->sendMessage(Main::format("Podaj dodatkowe informacje"));
            }
        } else {
            $player->sendMessage(Main::format("Podaj nick osoby ktora chcesz zglosic"));
        }

    }
}