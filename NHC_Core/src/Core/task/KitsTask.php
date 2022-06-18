<?php

namespace Core\task;

use pocketmine\scheduler\Task;

use Core\Main;

class KitsTask extends Task {
	
	public function onRun() : void {
		$db = Main::getInstance()->getDb();
		
		$result = $db->query("SELECT * FROM kits");
		
		while($row = $result->fetchArray(SQLITE3_ASSOC)) {

		    $a_date = date("H:i:s");

            if(strtotime($a_date) > strtotime($row['date'])) {
            	$nick = $row['nick'];
            	$kit = $row['kit'];

            	$db->query("DELETE FROM kits WHERE nick = '$nick' AND kit = '$kit'");
            }
		}
	}
}