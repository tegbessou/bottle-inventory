<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Enum;

enum Rate: string
{
    case MINUS_MINUS = '--';
    case MINUS = '-';
    case EQUAL = '=';
    case PLUS = '+';
    case PLUS_PLUS = '++';
    case SPLENDID = 'xs';
}
