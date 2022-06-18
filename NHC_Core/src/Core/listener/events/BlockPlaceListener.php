<?php

declare(strict_types=1);

namespace Core\listener\events;

use Core\format\Permission;
use Core\task\WaterTask;
use pocketmine\block\Water;
use Core\managers\ProtectManager;
use Core\drop\DropManager;
use Core\task\StoniarkaTask;
use Core\user\UserManager;
use pocketmine\block\Block;
use pocketmine\block\Lava;
use pocketmine\entity\object\ItemEntity;
use pocketmine\entity\object\PrimedTNT;
use pocketmine\event\block\BlockSpreadEvent;
use pocketmine\event\block\BlockUpdateEvent;
use pocketmine\event\entity\EntityCombustByEntityEvent;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\event\server\QueryRegenerateEvent;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\entity\Entity;
use pocketmine\item\enchantment\VanillaEnchantments;
use pocketmine\item\Item;
use pocketmine\entity\hostile\Creeper;
use pocketmine\item\ItemIds;
use pocketmine\nbt\tag\CompoundTag;
use pocketmine\nbt\tag\DoubleTag;
use pocketmine\nbt\tag\FloatTag;
use pocketmine\nbt\tag\ListTag;
use pocketmine\level;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\event\block\BlockPlaceEvent;
use pocketmine\event\Listener;
use Core\Main;
use pocketmine\network\mcpe\protocol\AddEntityPacket;
use pocketmine\network\mcpe\protocol\types\entity\EntityIds;
use pocketmine\player\GameMode;
use pocketmine\Server;

class BlockPlaceListener implements Listener {

    public function terrainBlockPlace(BlockPlaceEvent $e)
    {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $item = $player->getInventory()->getItemInHand();

        if (!ProtectManager::canPlace($player, $block))
            $e->cancel(true);


    }


    /**
     * @param BlockPlaceEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function BoyFarmer(BlockPlaceEvent $e)
    {
        $player = $e->getPlayer();

        $item = $player->getInventory()->getItemInHand();

        $x = $e->getBlock()->getPosition()->getFloorX();
        $z = $e->getBlock()->getPosition()->getFloorZ();
        if(Permission::isOp($player) or $player->getGamemode() == GameMode::CREATIVE()) return;



        if ($item->getId() == 49 && $item->getCustomName() == "§r§6BoyFarmer" && $item->hasEnchantment(17) && !$e->isCancelled()) {

            $e->cancel(true);

            $g_api = $player->getServer()->getPluginManager()->getPlugin("NHC_G");
            if(!$g_api->getGuildManager()->isInOwnPlot($player, $e->getBlock()) && !$player->hasPermission("NomenHC.permission.boyfarmer")) {
                $player->sendMessage("§r§8» §cNie mozesz stawiac tutaj boyfarmerow!");
                return;
            }

            $player->getInventory()->setItemInHand($item->setCount($item->getCount() - 1));

            $player->sendMessage("§r§8» §aPostawiono §2BoyFarmera§a!");

            for ($i = $e->getBlock()->getPosition()->getFloorY(); $i > 0;) {
                if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == \pocketmine\item\ItemIds::MOB_SPAWNER) return;
                if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == \pocketmine\item\ItemIds::BEDROCK) return;
                if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == \pocketmine\item\ItemIds::CARPET) return;

                $ids = [53, 67, 108, 109, 144, 128, 134, 135, 136, 156, 163, 164, 180, 203];
                foreach ($ids as $id) {
                    if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == $id) return;
                }


                $player->getWorld()->setBlock(new Vector3($x, $i, $z), BlockFactory::getInstance()->get(49));
                $i--;
            }
        }
    }

    /**
     * @param BlockPlaceEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function kopaczFarmer(BlockPlaceEvent $e)
    {
        $player = $e->getPlayer();

        $item = $player->getInventory()->getItemInHand();

        $x = $e->getBlock()->getPosition()->getFloorX();
        $z = $e->getBlock()->getPosition()->getFloorZ();

        if ($item->getId() == ItemIds::STONE && $item->getCustomName() == "§r§6KopaczFosy" && $item->hasEnchantment(17) && !$e->isCancelled()) {

            $e->cancel(true);

            $g_api = $player->getServer()->getPluginManager()->getPlugin("NHC_G");
            if(!$g_api->getGuildManager()->isInOwnPlot($player, $e->getBlock()) && !$player->hasPermission("NomenHC.permission.boyfarmer")) {
                $player->sendMessage("§r§8» §cNie mozesz stawiac tutaj kopazy!");
                return;
            }

            $player->getInventory()->setItemInHand($item->setCount($item->getCount() - 1));

            $player->sendMessage("§r§8» §aPostawiono §2KopaczFosy§a!");

            for ($i = $e->getBlock()->getPosition()->getFloorY(); $i > 0;) {
                if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == \pocketmine\item\ItemIds::MOB_SPAWNER) return;
                if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == \pocketmine\item\ItemIds::BEDROCK) return;
                if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == \pocketmine\item\ItemIds::CARPET) return;

                $ids = [53, 67, 108, 109, 144, 128, 134, 135, 136, 156, 163, 164, 180, 203];
                foreach ($ids as $id) {
                    if($player->getWorld()->getBlock(new Vector3($x, $i, $z))->getId() == $id) return;
                }

                $player->getWorld()->setBlock(new Vector3($x, $i, $z), BlockFactory::getInstance()->get(0));
                $i--;
            }
        }
    }



    public function TNT(BlockPlaceEvent $e)
    {
        $gracz = $e->getPlayer();

        $day = date('w', strtotime(date("Y-m-d")));
        $godz = date('G');
        if ($e->getBlock()->getId() == 46) {
            $e->cancel(true);
            if (!($godz >= 17 && $godz < 23)) {
                $e->cancel(true);
                $gracz->sendMessage(Main::format("TNT mozna stawiac w godzinach §917:00 §8- §923:00"));
            } else {
                if ($e->getBlock()->getPosition()->getFloorY() > 40) {
                    $e->cancel(true);
                    $gracz->sendMessage(Main::format("TNT mozna stawiac od §940 §7poziomu"));
                }
            }
        }
    }

    /*
        /**
     * @param BlockPlaceEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true

    public function Rzucak(BlockPlaceEvent $e)
    {
        $player = $e->getPlayer();

        $item = $player->getInventory()->getItemInHand();

        if ($item->getId() == 46 && $item->getCustomName() == "§r§l§eRzucane TNT" && $item->hasEnchantment(17)) {
            $e->cancel(true);

            $item->setCount(1);

            $player->getInventory()->removeItem($item);

            $pos = $player->add(0, $player->getEyeHeight());
            $motion = $player->getDirectionVector()->multiply(0.6);

            $nbt = Entity::createBaseNBT($pos, $motion);

            $entity = Entity::createEntity("PrimedTNT", $player->getWorld(), $nbt);
            $entity->spawnToAll();
        }
    }


    */

    /**
     * @param BlockPlaceEvent $e
     *
     * @priority MONITOR
     * @ignoreCancelled true
     */
    public function Rzucak(BlockPlaceEvent $e)
    {
        $player = $e->getPlayer();

        $item = $player->getInventory()->getItemInHand();

        if ($item->getId() == 52 && $item->getCustomName() == "§r§l§cRzucak" && $item->hasEnchantment(VanillaEnchantments::UNBREAKING())) {
            $e->cancel(true);

            $item->setCount(1);

            $player->getInventory()->removeItem($item);

            $pos = $player->getPosition()->add(0, $player->getEyeHeight(), 0);
            $motion = $player->getDirectionVector()->multiply(0.6);

            $nbt = Entity::createBaseNBT($pos, $motion);
            $entity = Entity::createEntity("PrimedTNT", $player->getWorld(), $nbt);
            $entity->spawnToAll();
        }
    }

    public function cobblex(BlockPlaceEvent $e) {
        $player = $e->getPlayer();
        $blok = $e->getBlock();
        $x = $blok->getPosition()->getFloorX();
        $y = $blok->getPosition()->getFloorY();
        $z = $blok->getPosition()->getFloorZ();

        $item = $player->getInventory()->getItemInHand();

        if($blok->getId() === 48 && !$e->isCancelled()) {
            $e->cancel(true);
            $item->setCount(1);
            $player->getInventory()->removeItem($item);
            switch (mt_rand(0, 5)) {
                case 0:
                    $count = mt_rand(8, 32);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK, 0, $count);
                    $player->getInventory()->addItem($item);
                    $format = "Diamentowe bloki x".$count;

                    break;

                case 1:
                    $count = mt_rand(8, 32);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD_BLOCK, 0, $count);
                    $player->getInventory()->addItem($item);
                    $format = "Emeraldowe bloki x".$count;

                    break;

                case 2:
                    $count = mt_rand(3, 25);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_BLOCK, 0, $count);
                    $player->getInventory()->addItem($item);
                    $format = "Zlote bloki x".$count;

                    break;

                case 3:
                    $count = mt_rand(8, 42);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BLOCK, 0, $count);
                    $player->getInventory()->addItem($item);
                    $format = "Zelazne bloki x".$count;

                    break;

                case 4:
                    $count = mt_rand(3, 22);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLDEN_APPLE, 0, $count);
                    $player->getInventory()->addItem($item);
                    $format = "Refy x".$count;

                    break;

                case 5:
                    $count = mt_rand(1, 10);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(466, 0, $count);
                    $player->getInventory()->addItem($item);
                    $format = "Koxy x".$count;

                    break;

                default:
                    "NIC";
            }
            $player->sendMessage(Main::format("Otworzyles cobblex i otrzymales §9".$format));
        }

    }


    public function place(BlockPlaceEvent $e)
    {
        $gracz = $e->getPlayer();
        $player = $gracz;

        $blok = $e->getBlock();
        $x = $blok->getPosition()->getFloorX();
        $y = $blok->getPosition()->getFloorY();
        $z = $blok->getPosition()->getFloorZ();

        $item = $gracz->getInventory()->getItemInHand();

        $godz = date('G');

        /*if ($blok->getPosition()->getFloorY() > 40) {

          $e->cancel(true);

        }*/


        $diamond = round(rand(0, 10000) / 100, 2) < 9.0;
        $gold = round(rand(0, 10000) / 100, 2) < 8.2;
        $emerald = round(rand(0, 10000) / 100, 2) < 8.3;

        $koxy = round(rand(0, 10000) / 100, 2) < 6.5;
        $refy = round(rand(0, 10000) / 100, 2) < 5.2;

        $miecz52 = round(rand(0, 10000) / 100, 2) < 5;
        $knock = round(rand(0, 10000) / 100, 2) < 5;
        $luk = round(rand(0, 10000) / 100, 2) < 4;
        $helm = round(rand(0, 10000) / 100, 2) < 7;
        $klata = round(rand(0, 10000) / 100, 2) < 7;
        $spodnie = round(rand(0, 10000) / 100, 2) < 7;
        $buty = round(rand(0, 10000) / 100, 2) < 7;
        $cx = round(rand(0, 10000) / 100, 2) < 6.8;

        $boyFarmer = round(rand(0, 10000) / 100, 2) < 8.9;
        $sandFarmer = round(rand(0, 10000) / 100, 2) < 0;
        $kopaczFos = round(rand(0, 10000) / 100, 2) < 8.9;

        $tnt = round(rand(0, 10000) / 100, 2) < 4;
        $beacon = round(rand(0, 10000) / 100, 2) < 1;
        $kilof633 = round(rand(0, 10000) / 100, 2) < 1.5;
        $rzucak = round(rand(0, 10000) / 100, 2) < 1;


        if($blok->getId() === ItemIds::DRAGON_EGG && !$e->isCancelled()) {
            $e->cancel();
            $item->setCount(1);
            $gracz->getInventory()->removeItem($item);
            switch (mt_rand(1, 17)) {

                case 1:
                    $ilosc = mt_rand(1, 4);

                    $item = \pocketmine\item\ItemFactory::getInstance()->get(48, 0, $ilosc);
                    $item->setCustomName("§r§9CobbleX");

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                    $itemFormat = "§9Cobblex x{$ilosc}";
                    break;

                case 2:

                    $ilosc = mt_rand(6, 45);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(49, 0, $ilosc);
                    $item->setCustomName("§r§6BoyFarmer");
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));


                    $itemFormat = "§9BoyFarmer x{$ilosc}";
                    break;


                case 3:
                    $ilosc = mt_rand(6, 48);

                    $item = \pocketmine\item\ItemFactory::getInstance()->get(1, 0, $ilosc);
                    $item->setCustomName("§r§6KopaczFosy");
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));


                    $itemFormat = "§9Kopacz fos x{$ilosc}";

                    break;

                case 4:
                    $ilosc = mt_rand(1, 29);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLD_BLOCK, 0, $ilosc);

                    $itemFormat = "§9Bloki zlota x{$ilosc}";
                    break;

                case 5:
                    $ilosc = mt_rand(4, 42);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_BLOCK, 0, $ilosc);

                    $itemFormat = "§9Bloki diamentow x{$ilosc}";
                    break;

                case 6:
                    $ilosc = mt_rand(9, 37);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::EMERALD_BLOCK, 0, $ilosc);

                    $itemFormat = "§9Bloki emeraldow x{$ilosc}";
                    break;

                case 7:
                    $ilosc = mt_rand(1, 4);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENCHANTED_GOLDEN_APPLE, 0, $ilosc);

                    $itemFormat = "§9Koxy x{$ilosc}";
                    break;

                case 8:
                    $ilosc = mt_rand(1, 18);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLDEN_APPLE, 0, $ilosc);

                    $itemFormat = "§9Refy x{$ilosc}";
                    break;

                case 9:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 5));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::FIRE_ASPECT(), 2));

                    $itemFormat = "§9Miecz 5/2";
                    break;

                case 10:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::SHARPNESS(), 5));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::KNOCKBACK(), 2));

                    $itemFormat = "§9Miecz Knock 5/2";
                    break;



                case 11:
                    $ilosc = mt_rand(3, 29);
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::TNT, 0, $ilosc);

                    $itemFormat = "§9TNT x{$ilosc}";
                    break;



                case 12:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOW);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::POWER(), 5));

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::INFINITY(), 1));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PUNCH(), 2));

                    $itemFormat = "§9Luk 5/1/2";
                    break;

                case 13:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_HELMET);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));

                    $itemFormat = "§9Helm 4/3";
                    break;
                case 14:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_CHESTPLATE);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));

                    $itemFormat = "§9Klata 4/3";
                    break;
                case 15:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_LEGGINGS);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));

                    $itemFormat = "§9Spodnie 4/3";
                    break;
                case 16:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BOOTS);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::PROTECTION(), 4));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::FEATHER_FALLING(), 2));

                    $itemFormat = "§9Buty 4/3/2";
                    break;

                case 17:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 5));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    // $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FORTUNE), 3));

                    $itemFormat = "§9Kilof 5/3/3";
                    break;


            }

            switch(mt_rand(1, 200)) {
                case 1:

                    $item = \pocketmine\item\ItemFactory::getInstance()->get(46);
                    $item->setCustomName("§r§l§9Rzucane TNT");
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 10));

                    $itemFormat = "§6RZUCAK";

                    break;

                case 2:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BEACON);

                    $itemFormat = "§6BEACON";
                    break;

                case 3:
                    $item = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);

                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::EFFICIENCY(), 6));
                    $item->addEnchantment(new EnchantmentInstance(VanillaEnchantments::UNBREAKING(), 3));
                    // $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FORTUNE), 3));

                    $itemFormat = "§6Kilof 6/3/3";
                    break;
            }

            if($item !== null) {
                if($player->getInventory()->canAddItem($item))
                    $player->getInventory()->addItem($item);
                else
                    $player->getWorld()->dropItem($e->getBlock()->getPosition()->asVector3(), $item);
            }


            $player->sendMessage(Main::format("Otworzyles PremiumCase i wylosowales §9$itemFormat"));
        }
    }
}
