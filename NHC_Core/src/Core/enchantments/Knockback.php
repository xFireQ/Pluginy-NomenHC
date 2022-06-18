<?php

namespace Core\enchantments;

use pocketmine\entity\Attribute;
use pocketmine\entity\Entity;
use pocketmine\entity\Living;
use pocketmine\item\enchantment\KnockbackEnchantment;

class Knockback extends KnockbackEnchantment
{

    public function onPostAttack(Entity $attacker, Entity $victim, int $enchantmentLevel): void
    {
        if ($victim instanceof Living) {
            $this->knockBack($victim, $victim->getX() - $attacker->getX(), $victim->getZ() - $attacker->getZ(), $enchantmentLevel * 0.4);
        }
    }

    private function knockBack(Entity $victim, float $x, float $z, float $base = 0.4): void
    {
        $f = sqrt($x * $x + $z * $z);
        if ($f <= 0) {
            return;
        }
        if (mt_rand() / mt_getrandmax() > $victim->getAttributeMap()->getAttribute(Attribute::KNOCKBACK_RESISTANCE)->getValue()) {
            $f = 1 / $f;
            $motion = clone $victim->getMotion();
            $motion->x /= 2;
            $motion->z /= 2;
            $motion->x += $x * $f * $base;
            $motion->z += $z * $f * $base;
            if ($victim->onGround) {
                $motion->y /= 2;
                $motion->y += $base;
                if ($motion->y > 0.4) {
                    $motion->y = 0.4;
                }
            }
            $victim->setMotion($motion);
        }
    }
}
