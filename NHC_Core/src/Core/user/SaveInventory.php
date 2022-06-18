<?php

declare(strict_types=1);


namespace Core\user;

use pocketmine\item\Item;
use pocketmine\player\Player;
use pocketmine\utils\Config;
use Core\Main;
use Core\fakeinventory\inventory\EnderchestInventory;

trait Saveinventory {

    /**
     * @param Player $player
     * @param string $inventory_name
     * @return Item[]|null
     */
    public function getInventoryContents(Player $player, string $inventory_name): ?array {
        $config = $this->getPlayerConfig($player);
        $contents = $config->get($inventory_name);
        return $contents !== false ? $contents : null;
    }

    public function getAllInventoryNames(Player $player): array {
        return $this->getPlayerConfig($player)->getAll(true);
    }

    public function saveInventory(Player $player, string $inventory_name): void {
        $config = $this->getPlayerConfig($player);
        $config->set($inventory_name, $player->getInventory()->getContents(true));
        $config->save();
    }

    public function removeInventory(Player $player, string $inventory_name): void {
        $config = $this->getPlayerConfig($player);
        $config->remove($inventory_name);
        $config->save();
    }

    public function openInventoriesForm(Player $player): void {
        $player->sendForm(new InventoryMenuForm());
    }

    private function getPlayerConfig(Player $player): Config {
        return new Config(Main::getInstance()->getDataFolder() . "inventories/" . strtolower($player->getName()) . ".sl", Config::SERIALIZED);
    }

        /**
     * @param Player $player
     * @param string $inventory_name
     * @return Item[]|null
     */
    public function getEnderInventoryContents(Player $player, string $inventory_name): ?array {
        $config = $this->getPlayerConfig($player);
        $contents = $config->get($inventory_name);
        return $contents !== false ? $contents : null;
    }

    public function getAllEnderInventoryNames(Player $player): array {
        return $this->getPlayerConfig($player)->getAll(true);
    }

    public function saveEnderInventory(Player $player, string $inventory_name): void {
        $config = $this->getPlayerConfig($player);
        $config->set($inventory_name, EnderchestInventory::$inv);
        $config->save();
    }

    public function removeEnderInventory(Player $player, string $inventory_name): void {
        $config = $this->getPlayerConfig($player);
        $config->remove($inventory_name);
        $config->save();
    }

    public function openEnderInventoriesForm(Player $player): void {
        $player->sendForm(new InventoryMenuForm());
    }

    private function getPlayerEnderConfig(Player $player): Config {
        return new Config(Main::getInstance()->getDataFolder() . "ec/" . strtolower($player->getName()) . ".sl", Config::SERIALIZED);
    }

}