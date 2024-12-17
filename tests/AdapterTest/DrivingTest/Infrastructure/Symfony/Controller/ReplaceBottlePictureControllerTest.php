<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Infrastructure\Symfony\Controller;

use EmpireDesAmis\BottleInventory\Tests\Shared\ApiTestCase;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;
use Symfony\Component\HttpFoundation\File\UploadedFile;

final class ReplaceBottlePictureControllerTest extends ApiTestCase
{
    use RefreshDatabase;

    #[\Override]
    protected function tearDown(): void
    {
        $this->revertUploadFile('cote-rotie*.png');

        parent::tearDown();
    }

    public function testUpdateBottlePicture(): void
    {
        $uploadedFile = new UploadedFile(
            __DIR__.'/../../../../../../fixtures/images/bottle/cote-rotie.png',
            'cote-rotie.png',
        );

        $this->postFile('/api/bottles/635e809c-aaaf-40df-8483-83cfbe2c5504/pictures', [
            'picture' => $uploadedFile,
        ]);

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            'name' => 'Guigal Côte-Rôtie',
            'estateName' => 'E. Guigal',
            'year' => 2014,
            'grapeVarieties' => ['Syrah', 'Viognier'],
            'wineType' => 'red',
            'rate' => '++',
            'ownerId' => 'hugues.gobet@gmail.com',
            'country' => 'France',
            'picturePath' => 'cote-rotie.png',
        ]);
        $this->assertFileExistsWithPartialName('cote-rotie*.png');
    }

    #[DataProvider('provideValidFiles')]
    public function testUpdateBottlePictureWithDifferentFormatFiles(
        UploadedFile $uploadedFile,
        string $uuid,
        string $partialName,
        string $name,
    ): void {
        $this->postFile(
            sprintf(
                '/api/bottles/%s/pictures',
                $uuid,
            ),
            [
                'picture' => $uploadedFile,
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(200);
        $this->assertFileExistsWithPartialName($partialName);

        $this->revertUploadFile($partialName, $name);
    }

    public static function provideValidFiles(): \Generator
    {
        yield 'Valid png file' => [
            'uploadedFile' => new UploadedFile(
                __DIR__.'/../../../../../../fixtures/images/bottle/cote-rotie.png',
                'cote-rotie.png',
            ),
            'uuid' => '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'partialName' => 'cote-rotie*.png',
            'name' => 'cote-rotie.png',
        ];

        yield 'Valid webp file' => [
            'uploadedFile' => new UploadedFile(
                __DIR__.'/../../../../../../fixtures/images/bottle/chateau-fonsalete.webp',
                'chateau-fonsalete.webp',
            ),
            'uuid' => '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'partialName' => 'chateau-fonsalete*.webp',
            'name' => 'chateau-fonsalete.webp',
        ];

        yield 'Valid jpg file' => [
            'uploadedFile' => new UploadedFile(
                __DIR__.'/../../../../../../fixtures/images/bottle/chateau-maraux.jpg',
                'chateau-maraux.jpg',
            ),
            'uuid' => '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'partialName' => 'chateau-maraux*.jpg',
            'name' => 'chateau-maraux.jpg',
        ];

        yield 'Valid jpeg file' => [
            'uploadedFile' => new UploadedFile(
                __DIR__.'/../../../../../../fixtures/images/bottle/ous-one.jpeg',
                'ous-one.jpeg',
            ),
            'uuid' => '635e809c-aaaf-40df-8483-83cfbe2c5504',
            'partialName' => 'ous-one*.jpg',
            'name' => 'ous-one.jpeg',
        ];
    }

    public function testUpdateBottlePictureBottleNotFound(): void
    {
        $uploadedFile = new UploadedFile(
            __DIR__.'/../../../../../../fixtures/images/bottle/cote-rotie.png',
            'cote-rotie.png',
        );

        $this->postFile('/api/bottles/1db0e325-0498-4f0b-963a-ddc2f6303622/pictures', [
            'picture' => $uploadedFile,
        ]);

        $this->assertResponseStatusCodeSame(404);
    }

    public function testUpdateBottlePictureBottleNotAuthorizeBecauseBottleIsOwnByOtherUser(): void
    {
        $uploadedFile = new UploadedFile(
            __DIR__.'/../../../../../../fixtures/images/bottle/cote-rotie.png',
            'cote-rotie.png',
        );

        $this->postFile('/api/bottles/97102d4c-da46-4105-8c34-53f5a2e1e9fa/pictures', [
            'picture' => $uploadedFile,
        ]);

        $this->assertResponseStatusCodeSame(403);
    }
}
