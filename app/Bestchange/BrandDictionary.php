<?php

declare(strict_types=1);

namespace App\Bestchange;

class BrandDictionary
{
    private const MAP = [
        1 => 585,
        2 => 950,
        3 => 716,
        4 => 157,
        5 => 604,
        6 => 1056,
        7 => 982,
        8 => 790,
        9 => 640,
        10 => 337,
        11 => 898,
        12 => 816,
        // 13 - telegram
        14 => 730,
        16 => 1256,
        18 => 921,
        19 => 1138,
        20 => 670,
        21 => 609,
        22 => 688,
    ];
    public static function getIdByBrandId(int $brandId): ?int
    {
        return self::MAP[$brandId] ?? null;
    }
}
