<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\CodeBuds;

final readonly class CompressPictureDto
{
    public function __construct(
        public string $picturePath,
        public string $pictureOriginalName,
    ) {
    }
}
