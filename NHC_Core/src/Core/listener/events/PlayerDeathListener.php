<?php

declare(strict_types=1);

namespace Core\listener\events;

use pocketmine\event\Listener;
use pocketmine\event\player\PlayerDeatchEvent;

use pocketmine\event\entity\EntityDamageEvent;
use pocketmine\event\entity\EntityDamageByEntityEvent;
use Core\Main;
use Core\managers\PointsManager;

class PlayerDeathListener implements Listener {
	
	
                //$p->sendMessage("§7Gracz §2{$killer_format} §8[§a+{$k_pkt}§8] §7zabija §2{$death_format} §8[§c-{$d_pkt}§8]" . (count($assists_pkt) == 0 ? "" : " " . $assists_format));
                
    
}