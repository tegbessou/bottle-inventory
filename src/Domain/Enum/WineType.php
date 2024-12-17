<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Enum;

enum WineType: string
{
    case RedWine = 'red';
    case WhiteWine = 'white';
    case RoseWine = 'rosé';
    case OrangeWine = 'orange';
    case ChampagneWine = 'champagne';
    case SparklingWine = 'sparkling';
}
