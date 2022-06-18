<?php

namespace Core\task;

use pocketmine\level\sound\AnvilBreakSound;
use pocketmine\level\sound\ClickSound;
use pocketmine\level\sound\EndermanTeleportSound;
use pocketmine\level\sound\PopSound;
use pocketmine\math\Vector3;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacket;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV1;
use pocketmine\network\mcpe\protocol\LevelSoundEventPacketV2;
use pocketmine\scheduler\Task;

use pocketmine\player\Player;

use pocketmine\Server;

use Core\Main;

class SpawnTask extends Task {
	
	private $player;
    private int $time;
	
	public function __construct(Player $player, int $time) {
		$this->player = $player;
        $this->time = $time+1;
	}
	
	public function onRun(): void {
		$player = $this->player;
        $this->time--;

        if(!$player->isOnline()) return;

        if($this->time === 0) {
            if(Server::getInstance()->getPlayerExact($player->getName())) {
                $level = $player->getWorld();
                $pos = $player->getPosition();
                //$level->addSound(new EndermanTeleportSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ())));
                //$player->teleport($player->getWorld()->getSafeSpawn());
                //$player->sendTip("§7AntyLogout: §c".(10 - (time())));
                $player->sendTip($this->format("&aTELEPORTACJA ZAKONCZONA!"));
                //$player->sendTitle("§l§9Spawn", "§7Teleportacja na spawn zostala zakonczona!");
                Main::$spawnTask[$player->getName()]->cancel();
                unset(Main::$spawnTask[$player->getName()]);
            }
        } else {
            $level = $player->getWorld();
            $pos = $player->getPosition();
            if($this->time === 10) {
                $player->sendTip($this->format("&r&7Teleportacja za &910s &8[&a|&7||||||||&7|&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));
            }

            if($this->time === 9) {
                $player->sendTip($this->format("&r&7Teleportacja za &99s &8[&a||&7||||||&7||&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 8) {
                $player->sendTip($this->format("&r&7Teleportacja za &98s &8[&a|||&7||||&7|||&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 7) {
                $player->sendTip($this->format("&r&7Teleportacja za &97s &8[&a||||&7||&7||||&8]"));
              //  $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 6) {
                $player->sendTip($this->format("&r&7Teleportacja za &96s &8[&a|||||&7|||||&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 5) {
                $player->sendTip($this->format("&r&7Teleportacja za &95s &8[&a||||||&7||||&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 4) {
                $player->sendTip($this->format("&r&7Teleportacja za &94s &8[&a|||||||&7|||&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 3) {
                $player->sendTip($this->format("&r&7Teleportacja za &93s &8[&a||||||||&7||&8]"));
                //$level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 2) {
                $player->sendTip($this->format("&r&7Teleportacja za &92s &8[&a|||||||||&7|&8]"));
                //$level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }

            if($this->time === 1) {
                $player->sendTip($this->format("&r&7Teleportacja za &91s &8[&a||||||||||&8]"));
               // $level->addSound(new ClickSound(new Vector3($pos->getX(), $pos->getY() + 1, $pos->getZ()), ));

            }
        }



	}

    public function format(string $msg): string {
        return str_replace("&", "§", $msg);
    }
}