<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\Get;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Provider\UpProvider;

#[Get('/up', provider: UpProvider::class)]
final readonly class UpResource
{
}
