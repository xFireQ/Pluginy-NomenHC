<?php

declare(strict_types=1);

namespace Core\managers;

use pocketmine\player\Player;
use Core\Main;
use Core\user\UserManager;
use Core\guild\GuildManager;

class FormatManager {
	
	public static function getFormat(Player $player, string $format, ?string $message = null) : string {
	    $nick = $player->getName();
        $group = Main::getInstance()->getGroupManager()->getPlayer($player->getName())->getGroup();

        $format = str_replace("&", "§", $format);
        $format = str_replace("{GROUP}", $group->getName(), $format);
        $format = str_replace("{DISPLAYNAME}", $player->getDisplayName(), $format);

        // CHAT MESSAGE
		if($message != null)
		 $format = str_replace("{MESSAGE}", $message, $format);

		   $user = UserManager::getUser($nick)->getPoints();
           $format = str_replace("{PKT}", "{$user->getPoints()}", $format);
           
           $g_api = $player->getServer()->getPluginManager()->getPlugin("NHC_G");
		
		    $g = $g_api->getGuildManager()->getPlayerGuild($player->getName());

		    if($g != null)
                $format = str_replace("{GUILD}", "{$g->getTag()}", $format);
		    else {
		        foreach(explode(" ", $format) as $word) {
                    if (strpos($word, "{GUILD}") != null) {
                        $format = str_replace(" ".$word, "", $format);
                    }
                }
            }

		return $format;
	}
}