<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\VichUploader;

use EmpireDesAmis\BottleInventory\Domain\Entity\Bottle;
use EmpireDesAmis\BottleInventory\Domain\Exception\ReplaceBottlePictureFileNotFoundException;
use EmpireDesAmis\BottleInventory\Domain\Service\UploadBottlePictureInterface;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\ReplaceBottlePictureResource;
use EmpireDesAmis\BottleInventory\Infrastructure\CodeBuds\CompressPicture;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Handler\UploadHandler;

final readonly class UploadBottlePictureVichUploader implements UploadBottlePictureInterface
{
    public function __construct(
        private UploadHandler $uploadHandler,
    ) {
    }

    #[\Override]
    public function upload(
        Bottle $bottle,
        string $picturePath,
        string $pictureOriginalName,
    ): string {
        try {
            $replacePictureBottleResource = new ReplaceBottlePictureResource();

            $file = new UploadedFile(
                $picturePath,
                $pictureOriginalName,
            );

            $replacePictureBottleResource->picture = $file;

            $this->uploadHandler->upload($replacePictureBottleResource, 'picture');

            if ($replacePictureBottleResource->picture === null) {
                throw new ReplaceBottlePictureFileNotFoundException();
            }

            $compressedPicture = CompressPicture::compressPicture(
                $replacePictureBottleResource->picture->getPathname(),
            );

            $this->uploadHandler->remove($replacePictureBottleResource, 'picture');

            return $compressedPicture->pictureOriginalName;
        } catch (FileNotFoundException) {
            throw new ReplaceBottlePictureFileNotFoundException();
        }
    }
}
