<?php

namespace Core\format;

use pocketmine\command\CommandSender;
use pocketmine\item\VanillaItems;
use pocketmine\player\Player;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\enchantment\VanillaEnchantments;

class Format
{

    public const COLOR = "§9";
    public const MARK_COLOR = "§7";


    public static function sendMessage(CommandSender $sender, int $type, string $message): void
    {
        $message = str_replace("&", "§", $message);

        if ($type === 0) {
            $sender->sendMessage("§r§7" . $message);
        } elseif ($type === 1) {
            $sender->sendMessage("§r§8» §7" . $message);
        } elseif ($type === 2) {
            $sender->sendMessage("§8[§9Nomen§fHC§8] §7" . $message);
        }
    }

    public static function give633Pickaxe(Player $player): void
    {
        $pickaxe = VanillaItems::DIAMOND_PICKAXE();
        $pickaxe->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
        $pickaxe->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
        $pickaxe->setCustomName("§r§6Kilof 6/3/3");
        $player->getInventory()->addItem($pickaxe);

    }
}