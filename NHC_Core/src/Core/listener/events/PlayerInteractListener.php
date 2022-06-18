<?php

namespace Core\listener\events;

use Core\form\Form;
use Core\format\Format;
use Core\managers\ProtectManager;
use Core\form\EnchantBowForm;
use Core\task\MeteoriteTask;
use Core\task\WaterTask;
use Core\user\UserManager;
use pocketmine\block\Block;
use pocketmine\block\BlockIds;
use pocketmine\event\inventory\InventoryTransactionEvent;
use pocketmine\item\Item;
use pocketmine\entity\hostile\Creeper;
use pocketmine\item\enchantment\Enchantment;
use pocketmine\item\enchantment\EnchantmentInstance;
use pocketmine\level;
use pocketmine\world\Position;
use pocketmine\math\Vector3;
use pocketmine\event\player\PlayerInteractEvent;
use pocketmine\command\ConsoleCommandSender;
use pocketmine\item\Pickaxe;
use pocketmine\item\{Arrow, Bow, Tool, Armor, Sword, ChainBoots, DiamondBoots, GoldBoots, IronBoots, LeatherBoots};
use pocketmine\item\{Axe, Hoe, ItemIds, Shovel};
use Core\form\AnvilMenuForm;
use Core\form\EnchantToolForm;
use Core\form\EnchantArmorForm;
use Core\form\EnchantSwordForm;
use Core\form\EnchantBootsForm;
use Core\fakeinventory\inventory\EnderchestInventory;
use pocketmine\event\Listener;
use Core\Main;
use pocketmine\player\Player;
use pocketmine\Server;

class PlayerInteractListener implements Listener {

    public function terrainInteract(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $block = $e->getBlock();
        $pos = $block->getPosition()->asPosition();
        $item = $player->getInventory()->getItemInHand();

        if($item->getId() === 259)
            $e->cancel(true);

        if($block->getId() == 122) {
            $e->cancel();
            if(MeteoriteTask::$hp === 0 or MeteoriteTask::$hp === null) {
                $level = Server::getInstance()->getWorldManager()->getDefaultWorld();
                $level->setBlockIdAt($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY(), $pos->getPosition()->getFloorZ(), 0);
                $itemFormat = " ";
                switch (mt_rand(0, 3)) {
                    case 0:
                        $items = [\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_HELMET), \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_CHESTPLATE), \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_LEGGINGS), \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_BOOTS)];
                        $swordK = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD);
                        $swordS = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::IRON_SWORD);
                        $swordK->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $swordS->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $swordK->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::KNOCKBACK), 2));
                        $swordK->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 4));
                        $swordS->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::SHARPNESS), 4));
                        $swordS->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::FIRE_ASPECT), 2));


                        foreach ($items as $item) {
                            $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                            $item->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::PROTECTION), 4));
                            $player->getInventory()->addItem($item);
                        }
                        $player->getInventory()->addItem($swordS);
                        $player->getInventory()->addItem($swordK);
                        $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENCHANTED_GOLDEN_APPLE));
                        $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLDEN_APPLE)->setCount(8));



                        $itemFormat = "kit VIP";
                        $level->addParticle(new level\particle\HugeExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));
                        $level->addParticle(new level\particle\ExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));
                        break;

                    case 1:
                        $pickaxe = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
                        $pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::EFFICIENCY), 6));
                        $pickaxe->setCustomName("§r§6Kilof 6/3/3");
                        $player->getInventory()->addItem($pickaxe);
                        $itemFormat = "Kilof 6/3/3";


                        $level->addParticle(new level\particle\HugeExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));
                        $level->addParticle(new level\particle\ExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));

                        break;

                    case 2:
                        $pickaxe = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::DIAMOND_PICKAXE);
                        $pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $pickaxe->addEnchantment(new EnchantmentInstance(Enchantment::getEnchantment(Enchantment::UNBREAKING), 3));
                        $pickaxe->setCustomName("§r§6Kilof 6/3/3");
                        $player->getInventory()->addItem($pickaxe);
                        $itemFormat = "Kilof 6/3/3";


                        $level->addParticle(new level\particle\HugeExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));
                        $level->addParticle(new level\particle\ExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));

                        break;

                    case 3:
                        $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::ENCHANTED_GOLDEN_APPLE, 0, 48));
                        $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLDEN_APPLE, 0, 8));

                        $itemFormat = "48 koxy";
                        $level->addParticle(new level\particle\HugeExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));
                        $level->addParticle(new level\particle\ExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));

                        break;

                    case 3:
                        $player->getInventory()->addItem(\pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::GOLDEN_APPLE, 0, 128));

                        $itemFormat = "128 refow";
                        $level->addParticle(new level\particle\HugeExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));
                        $level->addParticle(new level\particle\ExplodeParticle(new Vector3($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));

                        break;
                }

                Format::sendMessage($player, 1, "Gracz &9".$player->getName()." &r&7otworzyl meteoryta i wydropil: &9".$itemFormat);

            } else {
                $level = Server::getInstance()->getWorldManager()->getDefaultWorld();
                MeteoriteTask::$hp = MeteoriteTask::$hp - 1;
                $random = mt_rand(0, 10) / 10;
                $rand = 0;

                $level->addParticle(new level\particle\HappyVillagerParticle(new Position($pos->getX()+$rand, $pos->getY()+$rand, $pos->getZ()+$rand), 192, 196, 51));
                $level->addSound(new level\sound\BlazeShootSound(new Position($pos->getPosition()->getFloorX(), $pos->getPosition()->getFloorY() + 1, $pos->getPosition()->getFloorZ())));

            }
        }

        if($player->getInventory()->getItemInHand()->getId() === \pocketmine\item\ItemIds::BLAZE_ROD) {
            if($player->isSneaking()) {
                if(!isset(UserManager::$blazeRod[$player->getName()])) {
                    UserManager::$blazeRod[$player->getName()] = true;
                    $player->sendTitle("§r§l§9SYSTEM STONIAREK", "§8»§r§7Wlaczono tryb stoniarek");
                } else {
                    unset(UserManager::$blazeRod[$player->getName()]);
                    $player->sendTitle("§r§l§9SYSTEM STONIAREK", "§8»§r§7Wylaczono tryb stoniarek");

                }

            }
        }

        if(!ProtectManager::canInteract($player, $block))
            $e->cancel(true);
    }

    public function onInteract(PlayerInteractEvent $event){
        $blok = $event->getBlock();
        $player = $event->getPlayer();
        $nick = $event->getPlayer()->getName();
        $item = $player->getInventory()->getItemInHand();

        if($blok->getId() === ItemIds::ENCHANTING_TABLE) {
            $event->cancel();
                if($event->getAction() == PlayerInteractEvent::RIGHT_CLICK_BLOCK){
                     if ($item instanceof Sword) {
                       $player->sendForm(new EnchantSwordForm($player));
                     } elseif ($item->getId() == 261) {
                         $player->sendForm(new EnchantBowForm($player));
                   } elseif ($item instanceof Pickaxe || $item instanceof Shovel || $item instanceof Hoe or $item instanceof Axe){

                       $player->sendForm(new EnchantToolForm($player));
                   } elseif ($item instanceof Armor) {
                       if ($item instanceof ChainBoots || $item instanceof DiamondBoots || $item instanceof GoldBoots || $item instanceof IronBoots || $item instanceof LeatherBoots) {
                           $player->sendForm(new EnchantBootsForm($player));
                       } else {
                           $player->sendForm(new EnchantArmorForm($player));
                       }
                       } elseif ($item->getId() == 0) {
                            $player->sendMessage("§8»§7 Musisz trzymac w rece jakis przedmiot aby go zenchantowac!");
                   } else if($item instanceof Bow) {
                         $player->sendForm(new EnchantBowForm($player));
                     } else {
                         $player->sendMessage("§8»§7 Nie mozesz zenchantowac tego itemu!");
                     }
                }
        }


        if($item->getId() === \pocketmine\item\ItemIds::GOLD_BOOTS) {
            if ($item->hasEnchantments(17)) {
                foreach ($item->getEnchantments() as $enchantment) {
                    if ($enchantment->getWorld() >= 10) {
                        //Do something you want if the level is higher than 15
                        if(isset(Main::$lastDamager[$nick])) {
                            $damager = Main::$lastDamager[$nick];
                            $x = $damager->getPosition()->getFloorX();
                            $y = $damager->getPosition()->getFloorY();
                            $z = $damager->getPosition()->getFloorZ();

                            if(isset(Main::$antylogoutPlayers[$nick])) {
                                $item->setCount(1);
                                $player->getInventory()->removeItem($item);
                                $player->sendTitle("§r§l§6AntyNogi", "§r§7Pomylsnie uzyto antynog");
                                //$player->teleport(new Vector3($x, $y, $z));
                            } else {
                                $player->sendTitle("§r§6AntyNogi", "§r§7Musisz byc podczas walki!");
                                $player->sendMessage(Main::format("Musisz byc podczas walki aby to zrobic!"));
                            }

                        } else {
                            $player->sendMessage(Main::format("Musisz byc podczas walki aby to zrobic!"));
                        }
                    }
                }
            }
        }

        if($blok->getId() === ItemIds::ANVIL) {
            $event->cancel();
            if($event->getAction() == PlayerInteractEvent::RIGHT_CLICK_BLOCK){
                if ($item instanceof Sword) {
                    $player->sendForm(new AnvilMenuForm($player));
                } elseif ($item instanceof Bow) {
                    $player->sendForm(new AnvilMenuForm($player));
                } elseif ($item instanceof Tool) {
                    $player->sendForm(new AnvilMenuForm($player));
                } elseif ($item instanceof Armor) {
                    if ($item instanceof ChainBoots || $item instanceof DiamondBoots || $item instanceof GoldBoots || $item instanceof IronBoots || $item instanceof LeatherBoots) {
                        $player->sendForm(new AnvilMenuForm($player));
                    } else {
                        $player->sendForm(new AnvilMenuForm($player));
                    }
                } elseif ($item->getId() == 0) {
                    $player->sendMessage(Main::format("Musisz trzymac w rece jakis przedmiot aby go naprawic!"));
                } else {
                    $player->sendMessage(Main::format("Nie mozesz naprawic tego itemu!"));


                }
            }
        }

        if (isset(Main::$antylogoutPlayers[$nick])) {
            if ($blok->getId() == 130) {
                $event->cancel();
                $event->getPlayer()->sendMessage(Main::format("Nie mozesz OTWIERAC enderchesta podczas walki"));
            }
            if ($blok->getId() == 54) {
                $event->cancel();
                $event->getPlayer()->sendMessage(Main::format("Nie mozesz OTWIERAC skrzyni  podczas walki"));
            }
            if ($blok->getId() == 146) {
                $event->cancel();
                $event->getPlayer()->sendMessage(Main::format("Nie mozesz OTWIERAC skrzyni  podczas walki"));
            }
            if ($blok->getId() == 19) {
                $event->cancel();
                $event->getPlayer()->sendMessage(Main::format("Nie mozesz uzywac losowego tp  podczas walki"));
            }
        }
    }


    public function Voucher(PlayerInteractEvent $e) {
        $player = $e->getPlayer();
        $nick = $player->getName();
        $item = $player->getInventory()->getItemInHand();
        $voucher = \pocketmine\item\ItemFactory::getInstance()->get(\pocketmine\item\ItemIds::BOOK);
        $voucher->setCustomName("§r§eVoucher na range §eVIP");

        if($item->getId() === \pocketmine\item\ItemIds::BOOK && $item->getCustomName() === "§r§eVoucher na range §eVIP"){
            $item->setCount(1);
            $player->getInventory()->removeItem($item);
            $player->sendMessage(Main::format("Aktywowano voucher na range §eVIP"));
            $player->getServer()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $nick group set vip");
        }

        if($item->getId() === \pocketmine\item\ItemIds::BOOK && $item->getCustomName() === "§r§6Voucher na range §6SVIP"){
            $item->setCount(1);
            $player->getInventory()->removeItem($item);
            $player->sendMessage(Main::format("Aktywowano voucher na range §6SVIP"));
            $player->getServer()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $nick group set svip");
        }

        if($item->getId() === \pocketmine\item\ItemIds::BOOK && $item->getCustomName() === "§r§9Voucher na range §9SPONSOR"){
            $item->setCount(1);
            $player->getInventory()->removeItem($item);
            $player->sendMessage(Main::format("Aktywowano voucher na range §9SPONSOR"));
            $player->getServer()->dispatchCommand(new \pocketmine\console\ConsoleCommandSender, "pex user $nick group set sponsor");
        }
    }

    public function LosoweTP(PlayerInteractEvent $e)
    {
        if ($e->getBlock()->getId() === 19) {

            $e->cancel(true);

            $x = mt_rand(-550, 550);
            $z = mt_rand(-550, 550);
            $y = $e->getPlayer()->getWorld()->getHighestBlockAt($x, $z) + 1;

            $e->getPlayer()->teleport(new Vector3($x, $y, $z));
        }
    }

    public function GrupoweTP(PlayerInteractEvent $e)
    {
        $player = $e->getPlayer();

        $block = $e->getBlock();

        if ($block->getId() == 25) {
            $players = [];

            if ($player->distance($block) > 3)
                return;

            foreach ($player->getServer()->getDefaultLevel()->getPlayers() as $p) {
                if ($p->distance($block) <= 3)
                    $players[] = $p;
            }

            if (count($players) < 2) {
                foreach ($players as $p)
                    $p->sendMessage(Main::format("Brakuje jeszcze §c1 §7gracza!"));
                return;
            }

            $x = mt_rand(300, 550);
            $z = mt_rand(300, 550);
            $y = $e->getPlayer()->getWorld()->getHighestBlockAt($x, $z) + 1;

            foreach ($players as $p) {
                $p->teleport(new Vector3($x, $y, $z));
            }
        }
    }
}
