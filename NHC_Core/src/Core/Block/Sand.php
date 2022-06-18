<?php
declare(strict_types=1);

namespace Core\block;

use pocketmine\block\BlockToolType;
use pocketmine\block\Fallable;

class Sand extends Fallable {

    protected $id = self::SAND;

    public function __construct(int $meta = 0){
        $this->meta = $meta;
    }

    public function getHardness() : float{
        return 8;
    }

    public function getToolType() : int{
        return BlockToolType::TYPE_SHOVEL;
    }

    public function getName() : string{
        if($this->meta === 0x01){
            return "Red Sand";
        }

        return "Sand";
    }

}