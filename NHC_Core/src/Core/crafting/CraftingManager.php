<?php

declare(strict_types=1);

namespace Core\crafting;

use Core\util\ItemUtil;
use pocketmine\inventory\ShapelessRecipe;
use pocketmine\Server;
use pocketmine\utils\Config;

class CraftingManager {

    private static $craftingRecipes = [];

    public static function init(Config $config) : void {
        foreach($config->get("craftingi") as $name => $craftingData) {
            $items = [];

            foreach($craftingData['items'] as $itemData) {
                $item = ItemUtil::itemFromConfig($itemData);

                if($item !== null)
                    $items[] = $item;
            }

            self::$craftingRecipes[$name] = new CraftingRecipe($items, ItemUtil::itemFromConfig($craftingData['result']));
        }

        $craftingManager = Server::getInstance()->getCraftingManager();

        foreach(self::$craftingRecipes as $name => $craftingRecipe) {
            if(strtolower($name) === "cobblex")
                continue;

            $newItems = [];

            foreach($craftingRecipe->getItems() as $item)
                $newItems[] = clone $item;

            $craftingManager->registerShapelessRecipe(new ShapelessRecipe($newItems, [clone $craftingRecipe->getResult()]));
        }
    }

    /**
     * @return CraftingRecipe[]
     */
    public static function getCraftingRecipes() : array {
        return self::$craftingRecipes;
    }
}