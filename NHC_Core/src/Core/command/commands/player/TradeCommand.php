<?php

declare(strict_types=1);

namespace Core\command\commands\player;

use pocketmine\command\{
    Command, CommandSender
};
use pocketmine\utils\Config;
use Core\command\BaseCommand;
use Core\utils\Utils;
use Core\settings\SettingsManager;
use pocketmine\player\Player;
use Core\Main;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\inventory\Inventory;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;

class TradeCommand extends BaseCommand
{
    public function __construct()
    {
        parent::__construct("trade", "komenda wymiana", ["wymiana"], false);
    }

    public function onCommand(CommandSender $sender, array $args): void
    {
        foreach ($sender->getInventory()->getContents() as $item) {
            if ($item->getId() == \pocketmine\item\ItemIds::IRON_LEGGINGS) {
                $newItem = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_LEGGINGS);
                if($item->hasEnchantment(17)) {
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), $item->getEnchantment(17)->getWorld()));
                }

                if($item->hasEnchantment(0)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), $item->getEnchantment(0)->getWorld()));
                }

                $sender->getInventory()->removeItem($item);
                $sender->getInventory()->addItem($newItem);
            }
        }
        foreach ($sender->getInventory()->getContents() as $item) {

            if ($item->getId() == \pocketmine\item\ItemIds::IRON_HELMET) {
                $newItem = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_HELMET);
                if($item->hasEnchantment(17)) {
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), $item->getEnchantment(17)->getWorld()));
                }

                if($item->hasEnchantment(0)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), $item->getEnchantment(0)->getWorld()));
                }
                $sender->getInventory()->removeItem($item);
                $sender->getInventory()->addItem($newItem);
            }
        }
        foreach ($sender->getInventory()->getContents() as $item) {

            if ($item->getId() == \pocketmine\item\ItemIds::IRON_BOOTS) {
                $newItem = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BOOTS);
                if($item->hasEnchantment(17)) {
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), $item->getEnchantment(17)->getWorld()));
                }

                if($item->hasEnchantment(0)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), $item->getEnchantment(0)->getWorld()));
                }
                $sender->getInventory()->removeItem($item);
                $sender->getInventory()->addItem($newItem);
            }
        }
        foreach ($sender->getInventory()->getContents() as $item) {


            if ($item->getId() == \pocketmine\item\ItemIds::IRON_CHESTPLATE) {
                $newItem = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_CHESTPLATE);
                if($item->hasEnchantment(17)) {
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), $item->getEnchantment(17)->getWorld()));
                }

                if($item->hasEnchantment(0)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(0), $item->getEnchantment(0)->getWorld()));
                }
                $sender->getInventory()->removeItem($item);
                $sender->getInventory()->addItem($newItem);
            }
        }
        foreach ($sender->getInventory()->getContents() as $item) {


            if ($item->getId() == \pocketmine\item\ItemIds::IRON_SWORD) {
                $newItem = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD);
                if($item->hasEnchantment(17)) {
                    $newItem->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), $item->getEnchantment(17)->getWorld()));
                }

                if($item->hasEnchantment(9)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(9), $item->getEnchantment(9)->getWorld()));
                }

                if($item->hasEnchantment(13)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(13), $item->getEnchantment(13)->getWorld()));
                }

                if($item->hasEnchantment(12)) {
                    $newItem->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(12), $item->getEnchantment(12)->getWorld()));
                }

                $sender->getInventory()->removeItem($item);
                $sender->getInventory()->addItem($newItem);
            }
        }
    }
}