<?php

namespace Core\particle;

use pocketmine\Server;
use pocketmine\player\Player;

use Core\Main;

class ParticleManager {
  
    public static function init() : void {
        $x = GuildManager::getHeartZ();
        $z = GuildManager::getHeartX();
        
        $text = "§7Gildia: §2";
        
        $leader->getWorld()->addParticle(new FloatingTextParticle(new Vector3($x, 31, $z), $text));
    }
    
    
    
}