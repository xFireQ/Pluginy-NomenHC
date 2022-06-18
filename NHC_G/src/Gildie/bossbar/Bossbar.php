<?php

namespace Gildie\bossbar;

use pocketmine\player\Player;

use pocketmine\math\Vector3;

use pocketmine\entity\{
	Entity, Attribute, EntityIds
};

use pocketmine\network\mcpe\protocol\{
	AddActorPacket,
	AddEntityPacket,
	BossEventPacket,
	RemoveActorPacket,
	RemoveEntityPacket,
	SetActorDataPacket,
	UpdateAttributesPacket
};

class Bossbar extends Vector3 {
	
	private $healthPercent = 0;
	private $entityId;
	private $metadata = [];
	private $viewers = [];

	public function __construct(string $title = "Bossbar", float $hp = 1.0) {

	}

	public function setTitle(string $t, bool $update = true) : void {

	}

	public function getTitle() : string {
        return " ";
	}
	
	public function setHealthPercent(float $hp, bool $update = true) : void {

	}

	public function getHealthPercent() : float {
        return 0;
	}

	public function showTo(Player $player, bool $isViewer = true) : void {

	}

	public function hideFrom(Player $player) : void {

	}
	
	public function hideFromAll() : void {

	}

	public function updateFor(Player $player) : void {

	}

	public function updateForAll() : void {

	}

	private function getHealthPacket() : UpdateAttributesPacket {

	}

	private function sendBossEventPacket(Player $player, int $eventType) : void {

	}

	public function setMetadata(int $key, int $dtype, $value) : void {
	}
	
	public function getMetadata(int $key) {
	}

	public function getViewers() : array {
        return [];
	}

	public function getEntityId() : int {
        return 0;
	}
}