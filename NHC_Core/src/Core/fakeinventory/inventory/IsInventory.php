<?php

declare(strict_types=1);

namespace Core\fakeinventory\inventory;

use Core\fakeinventory\FakeInventory;
use Core\managers\WebhookManager;
use Core\webhook\types\Embed;
use Core\webhook\types\Message;
use pocketmine\item\Item;
use pocketmine\player\Player;
use Core\managers\IsManager;
use Core\Main;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Server;

class IsInventory extends FakeInventory {

    public function __construct(Player $player) {
        parent::__construct($player, "§r§l§9USLUGI", \Core\fakeinventory\FakeInventorySize::LARGE_CHEST);
        $this->setItems($player);
    }

    public function setItems(Player $player) : void {
        $nick = $player->getName();
        if(!IsManager::userExists($nick)) return;
        $services = IsManager::getUslugi($nick);
        $i = 0;
        foreach ($services as $service) {
            $this->setItem($i, \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::MOB_HEAD, 3, 1)->setCustomName("§r§l§7Usluga: §9".$service));
            $i++;
        }

    }

    public function onTransaction(Player $player, Item $sourceItem, Item $targetItem, int $slot) : bool {
        $nick = $player->getName();

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9vip") {
            IsManager::removeUsluga($nick, "vip");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $nick group set vip 30d");
           foreach(Server::getInstance()->getOnlinePlayers() as $p) {
               $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
               $p->sendMessage("§8» §7Gracz §9$nick §7zakupil range §9VIP NA EDYCJE");
               $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
               $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
               $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
               $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil range VIP");
           }


            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil range VIP!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");
            //$embed->setDescription("");
            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");

            $this->changeInventory($player, new IsInventory($player));
        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9pc512") {
            IsManager::removeUsluga($nick, "pc512");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "casegive $nick 512");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 512 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 512 PANDOR!");
            }

            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil 512 Pandor!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9256") {
            IsManager::removeUsluga($nick, "pc256");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "casegive $nick 256");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 256 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 256 PANDOR!");
            }

            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil 256 Pandor!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9pc128") {
            IsManager::removeUsluga($nick, "pc128");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 128 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 128 PANDOR!");

            }

            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9pc64") {
            IsManager::removeUsluga($nick, "pc64");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "casegive $nick 64");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 64 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 64 PANDOR!");

            }

            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil 64 Pandor!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9pc32") {
            IsManager::removeUsluga($nick, "pc32");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "casegive $nick 32");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 32 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 32 PANDOR!");

            }

            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil 32 Pandor!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9pc16") {
            IsManager::removeUsluga($nick, "pc16");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "casegive $nick 16");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 16 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 16 PANDOR!");

            }

            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil 16 Pandor!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9pc8") {
            IsManager::removeUsluga($nick, "pc8");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "casegive $nick 8");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil§9 8 PANDOR!");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil 8 PANDOR!");
            }

            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil 8 Pandor!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9sponsor") {
            IsManager::removeUsluga($nick, "sponsor");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $nick group set sponsor 30d");

            foreach(Server::getInstance()->getOnlinePlayers() as $p){
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil range §9SPONSOR NA EDYCJE");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil range SPONSOR");

            }
            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil range SPONSOR!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");
            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }

        if($sourceItem->getCustomName() == "§r§l§7Usluga: §9svip") {
            IsManager::removeUsluga($nick, "svip");
            Server::getInstance()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $nick group set svip 30d");
            foreach(Server::getInstance()->getOnlinePlayers() as $p) {
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendMessage("§8» §7Gracz §9$nick §7zakupil range §9SVIP NA EDYCJE");
                $p->sendMessage("§8» §7Dziekujemy za wsparcie!");
                $p->sendMessage("§8» §7Nasza strona §9www.NomenHC.PL");
                $p->sendMessage("§8[ §7----------- §8[§l§9ItemShop§r§8] §7----------- §8]");
                $p->sendTitle("§l§eItemShop", "§r§6Gracz $nick zakupil range SVIP");
            }


            $webhook = new Message();
            $webhook->setUserName("NomenHC | ItemShop");
            $embed = new Embed();
            $embed->setTitle("Gracz **__{$nick}__** zakupil range SVIP!");
            $embed->addField("Strona:", "www.NomenHC.PL \n**Dziekujemy za wsparcie!**");

            $embed->setColor(0x00008B);
            $embed->setThumbnail("https://minotar.net/avatar/{$nick}.png");
            $webhook->setEmbed($embed);

            WebhookManager::sendWebhook($webhook, "https://discordapp.com/api/webhooks/940219830383017994/mZ1ayEjBjEaSTM30Szose_HqJRJ9A0L6bAu0S1F_Kpgec6tGGY7xJ4Esla30BkyacNy9");
            $this->changeInventory($player, new IsInventory($player));

        }


        return true;
    }
}