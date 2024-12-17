<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource;

use ApiPlatform\Metadata\ApiProperty;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Post;
use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Controller\ReplaceBottlePictureController;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[Vich\Uploadable]
#[ApiResource(
    shortName: 'Bottle',
)]
#[Post(
    uriTemplate: '/bottles/{id}/pictures',
    inputFormats: ['multipart' => ['multipart/form-data']],
    status: Response::HTTP_OK,
    controller: ReplaceBottlePictureController::class,
    deserialize: false,
)]
final class ReplaceBottlePictureResource
{
    public function __construct(
        #[ApiProperty]
        #[Assert\File(mimeTypes: ['image/jpeg', 'image/jpg', 'image/webp', 'image/png'])]
        #[Vich\UploadableField(mapping: 'bottles', fileNameProperty: 'picturePath')]
        public ?File $picture = null,
        #[ApiProperty]
        public ?string $picturePath = null,
    ) {
    }
}
