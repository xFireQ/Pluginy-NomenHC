<?php
/**
 * Created by PhpStorm.
 * User: jkorn2324
 * Date: 2020-06-13
 * Time: 18:02
 */

declare(strict_types=1);

namespace Core\util;

class PvPKnockback
{

    /** @var float */
    private $xKB, $yKB;

    /** @var int */
    private $speed;

    public function __construct(float $x = 0.4, float $y = 0.4, int $speed = 10)
    {
        $this->xKB = $x;
        $this->yKB = $y;

        $this->speed = $speed;
    }
}