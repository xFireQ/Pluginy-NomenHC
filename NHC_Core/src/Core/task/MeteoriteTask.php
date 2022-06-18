<?php

namespace Core\task;

use Core\bossbar\BossBar;
use Core\bossbar\BossbarManager;
use pocketmine\block\Block;
use pocketmine\level\particle\FloatingTextParticle;
use pocketmine\world\Position;
use pocketmine\Server;
use Core\format\Format;
use pocketmine\scheduler\Task;
use pocketmine\scheduler\TaskHandler;
use Core\Main;
use pocketmine\utils\ReversePriorityQueue;
use pocketmine\math\Vector3;

class MeteoriteTask extends Task {

    private $time;
    private $dtime;
    private $x;
    private $y;
    private $z;
    private $text;
    public static int $hp;

    public function __construct(int $time, int $x, int $y, int $z) {
        $this->time = $time + 1;
        $this->dtime = $time + 1;
        $this->x = $x;
        $this->y = $y;
        $this->z = $z;
        $this->text = new FloatingTextParticle(new Position($x, $y+3, $z), "§r§7HP: &9".self::$hp."§8/§9100§r§7", "§r§9METEORYT");


    }

    public function onRun(): void {
        $this->time--;
        $time = $this->time;
        $x = $this->x;
        $y = $this->y;
        $z = $this->z;

        $bossbar = new BossBar();
        if($this->time >= 1) {
            foreach (Server::getInstance()->getOnlinePlayers() as $player) {
                if($player === null) return;
                $bossbar = BossbarManager::getBossbar($player);
                $bossbar->hideFrom($player);
                $bossbar = new \Core\bossbar\Bossbar("");
                $bossbar->showTo($player);
                $bossbar->setTitle($this->format("§r§8» &7METEORYT POJAWI SIE NA KORDACH: §7&7X:&9".$x."&7 Y:&9".$y."&7 Z:&9".$z));
            }
        }


        $players = Server::getInstance()->getOnlinePlayers();

        if($time === 60*60*24) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &91 dzien&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }
        if($time === 60*60*12) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &912 godzin&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        } if($time === 60*60*8) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &98 godzin&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 60*60*4) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &94 godziny&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 60*60) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &91 godzine&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 60*30) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &930 minut&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 60*10) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &910 minut&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 60*2) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &92 minuty&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 30) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &930 sekund&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));

        }

        if($time === 5) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawi sie za &95 sekund&7 na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));
        }

        $level = Server::getInstance()->getWorldManager()->getDefaultWorld();

        if($time === 0) {
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&9METEORYT &7pojawil sie na kordach: "));
            Server::getInstance()->broadcastMessage($this->format("§r§8» §7&7X: &9".$x."&7 Y: &9".$y."&7 Z:&9 ".$z));
            self::$hp = 100;
            //$this->explorer->currentSubChunk->setFullBlock($x, $y, $z, \pocketmine\item\ItemIds::DRAGON_EGG);
        }

        if($this->time === -1) {
            $level->setBlockIdAt($x, $y, $z, \pocketmine\item\ItemIds::EMERALD_BLOCK);
            $level->setBlockIdAt($x, $y+1, $z, \pocketmine\item\ItemIds::EMERALD_BLOCK);
            $level->setBlockIdAt($x, $y, $z+1, \pocketmine\item\ItemIds::EMERALD_BLOCK);
            $level->setBlockIdAt($x, $y, $z-1, \pocketmine\item\ItemIds::EMERALD_BLOCK);
            $level->setBlockIdAt($x+1, $y, $z, \pocketmine\item\ItemIds::EMERALD_BLOCK);
            $level->setBlockIdAt($x-1, $y, $z, \pocketmine\item\ItemIds::EMERALD_BLOCK);
            $level->setBlockIdAt($x, $y+2, $z, \pocketmine\item\ItemIds::DRAGON_EGG);

        }

        if($time === -2) {
            $level = Server::getInstance()->getWorldManager()->getDefaultWorld();
            //$level->setBlockIdAt($x, $y+4, $z, 0);
        }

        if($time <= -2) {
            $level = Server::getInstance()->getWorldManager()->getDefaultWorld();

            if(self::$hp >= 1) {
                $this->text->setText("§r§8» §r§7HP: §9".self::$hp."§8/§9100§r§7 \n§r§8» §7Kliknij §9PPM §7aby odebrac hp", "§r§9METEORYT");
                $level->addParticle($this->text);
                $bossbar->hideFromAll();
                $bossbar->setTitle($this->format("§r§8» &7METEORYT POSIADA: &9".self::$hp."&8/&9100 HP"));
                $players = Server::getInstance()->getOnlinePlayers();
                foreach ($players as $player)
                    $bossbar->showTo($player);
            } else {
                $bossbar->hideFromAll();
                $this->text->setText(" ", " ");
                $this->text->setInvisible();
                $level->addParticle($this->text);
            }


        }

    }

    public function format(string $msg): string {
        return str_replace("&", "§", $msg);
    }

}