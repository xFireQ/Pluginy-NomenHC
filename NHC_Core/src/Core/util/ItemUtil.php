<?php

declare(strict_types=1);

namespace Core\util;

use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\item\Item;

class ItemUtil {

    public static function itemFromConfig(string $fullItemData) : ?Item {
        $fullItemData = explode(';', $fullItemData);

        $itemData = explode(':', $fullItemData[0]);
        $itemId = is_numeric($itemData[0]) ? (int) $itemData[0] : self::getItemIdByName($itemData[0]);
        $itemDamage = isset($itemData[1]) ? (int) $itemData[1] : 0;
        $itemCount = isset($itemData[2]) ? (int) $itemData[2] : 1;

        if($itemId === null || $itemData === null)
            return null;

        $item = \pocketmine\item\ItemFactory::getInstance()->get($itemId, $itemDamage);
        $item->setCount($itemCount);

        if(isset($fullItemData[1]) && $fullItemData[1] != "")
            $item->setCustomName(ChatUtil::fixColors($fullItemData[1]));

        if(isset($fullItemData[2])) {
            for($i = 2; $i < count($fullItemData); $i++) {
                $enchData = explode(':', $fullItemData[$i]);
                $enchantment = is_numeric($enchData[0]) ? Enchantment::getEnchantment((int) $enchData[0]) : Enchantment::getEnchantmentByName($enchData[0]);
                $item->addEnchantment(new EnchantmentInstance($enchantment, (int) $enchData[1]));
            }
        }
        return $item;
    }

    public static function getItemIdByName(string $name) : ?int {
        $const = \pocketmine\item\ItemIds::class . "::" . strtoupper($name);
        if(defined($const)){
            return constant($const);
        }

        return null;
    }
}