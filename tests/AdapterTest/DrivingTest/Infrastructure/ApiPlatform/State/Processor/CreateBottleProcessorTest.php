<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Infrastructure\ApiPlatform\State\Processor;

use EmpireDesAmis\BottleInventory\Tests\Shared\ApiTestCase;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;

final class CreateBottleProcessorTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testCreateBottle(): void
    {
        $this->post('/api/bottles', [
            'name' => 'Pavillon Rouge du Château Margaux',
            'estateName' => 'Château Margaux',
            'year' => 1995,
            'grapeVarieties' => ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
            'wineType' => 'red',
            'rate' => 'xs',
            'ownerId' => 'hugues.gobet@gmail.com',
            'country' => 'France',
        ]);

        $this->assertResponseStatusCodeSame(201);
        $this->assertJsonContains([
            '@context' => '/api/contexts/Bottle',
            '@type' => 'Bottle',
            'name' => 'Pavillon Rouge du Château Margaux',
            'estateName' => 'Château Margaux',
            'year' => 1995,
            'grapeVarieties' => ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
            'wineType' => 'red',
            'rate' => 'xs',
            'ownerId' => 'hugues.gobet@gmail.com',
            'country' => 'France',
        ]);
    }

    #[DataProvider('provideInvalidData')]
    public function testCreateBottleWithInvalidData(
        array $payload,
        int $statusCode,
        array $violations,
    ): void {
        $this->post('/api/bottles', $payload);
        $this->assertResponseStatusCodeSame($statusCode);

        if ($statusCode === 422) {
            $this->assertJsonContains([
                '@type' => 'ConstraintViolationList',
                'title' => 'An error occurred',
                'violations' => $violations,
            ]);
        }
    }

    public static function provideInvalidData(): \Generator
    {
        yield 'No data passed' => [
            'payload' => [],
            'statusCode' => 422,
            'violations' => [
                [
                    'propertyPath' => 'name',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
                [
                    'propertyPath' => 'estateName',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
                [
                    'propertyPath' => 'wineType',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
                [
                    'propertyPath' => 'year',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
                [
                    'propertyPath' => 'grapeVarieties',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
                [
                    'propertyPath' => 'rate',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
                [
                    'propertyPath' => 'ownerId',
                    'message' => 'Cette valeur ne doit pas être vide.',
                    'code' => 'c1051bb4-d103-4f74-8988-acbcafc7fdc3',
                ],
            ],
        ];

        yield 'Bad wine type value' => [
            'payload' => [
                'name' => 'Pavillon Rouge du Château Margaux',
                'estateName' => 'Château Margaux',
                'year' => 1995,
                'grapeVarieties' => ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'yellow',
                'rate' => 'xs',
                'ownerId' => 'hugues.gobet@gmail.com',
                'country' => 'France',
            ],
            'statusCode' => 400,
            'violations' => [],
        ];

        yield 'Bad rate value' => [
            'payload' => [
                'name' => 'Pavillon Rouge du Château Margaux',
                'estateName' => 'Château Margaux',
                'year' => 1995,
                'grapeVarieties' => ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'top',
                'ownerId' => 'hugues.gobet@gmail.com',
                'country' => 'France',
            ],
            'statusCode' => 400,
            'violations' => [],
        ];

        yield 'Owner bad email' => [
            'payload' => [
                'name' => 'Pavillon Rouge du Château Margaux',
                'estateName' => 'Château Margaux',
                'year' => 1995,
                'grapeVarieties' => ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'xs',
                'ownerId' => 'hugues.gobet',
                'country' => 'France',
            ],
            'statusCode' => 422,
            'violations' => [
                [
                    'propertyPath' => 'ownerId',
                    'message' => 'Cette valeur n\'est pas une adresse email valide.',
                    'code' => 'bd79c0ab-ddba-46cc-a703-a7a4b08de310',
                ],
            ],
        ];

        yield 'One grape varieties doesn\'t exist' => [
            'payload' => [
                'name' => 'Pavillon Rouge du Château Margaux',
                'estateName' => 'Château Margaux',
                'year' => 1995,
                'grapeVarieties' => ['Riesling', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'xs',
                'ownerId' => 'hugues.gobet@gmail.com',
                'country' => 'France',
            ],
            'statusCode' => 422,
            'violations' => [
                [
                    'propertyPath' => 'grapeVarieties',
                    'message' => "Le cépage portant le nom Riesling n'existe pas.",
                ],
            ],
        ];

        yield 'Many grape varieties doesn\'t exist' => [
            'payload' => [
                'name' => 'Pavillon Rouge du Château Margaux',
                'estateName' => 'Château Margaux',
                'year' => 1995,
                'grapeVarieties' => ['Riesling', 'Négrette', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'xs',
                'ownerId' => 'hugues.gobet@gmail.com',
                'country' => 'France',
            ],
            'statusCode' => 422,
            'violations' => [
                [
                    'propertyPath' => 'grapeVarieties',
                    'message' => "Les cépages portant le nom Riesling, Négrette n'existent pas.",
                ],
            ],
        ];

        yield 'Country doesn\'t exist' => [
            'payload' => [
                'name' => 'Pavillon Rouge du Château Margaux',
                'estateName' => 'Château Margaux',
                'year' => 1995,
                'grapeVarieties' => ['Cabernet Sauvignon', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'xs',
                'ownerId' => 'hugues.gobet@gmail.com',
                'country' => 'Italy',
            ],
            'statusCode' => 422,
            'violations' => [],
        ];
    }
}
