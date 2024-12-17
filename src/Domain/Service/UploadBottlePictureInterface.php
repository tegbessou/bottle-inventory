<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\Service;

use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;

interface UploadBottlePictureInterface
{
    public function upload(Bottle $bottle, string $picturePath, string $pictureOriginalName): string;
}
