<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\CodeBuds;

use CodeBuds\WebPConverter\WebPConverter;

final readonly class CompressPicture
{
    public static function compressPicture(string $path): CompressPictureDto
    {
        $compressedPicture = WebPConverter::createWebpImage(
            $path,
            [
                'saveFile' => true,
                'force' => true,
                'quality' => 10,
            ],
        );

        return new CompressPictureDto(
            $compressedPicture['path'],
            sprintf(
                '%s.webp',
                $compressedPicture['options']['filename'],
            ),
        );
    }
}
