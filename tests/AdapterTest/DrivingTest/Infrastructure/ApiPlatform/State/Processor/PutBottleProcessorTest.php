<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Infrastructure\ApiPlatform\State\Processor;

use EmpireDesAmis\BottleInventory\Tests\Shared\ApiTestCase;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;

final class PutBottleProcessorTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testUpdateBottle(): void
    {
        $this->put('/api/bottles/7bd55df3-e53c-410b-83a4-8e5ed9bcd50d', [
            'name' => 'Grange',
            'estateName' => 'Penfolds',
            'year' => 2018,
            'grapeVarieties' => ['Syrah'],
            'wineType' => 'red',
            'rate' => 'xs',
            'country' => 'France',
            'price' => 620.00,
        ]);

        $this->assertResponseStatusCodeSame(200);
        $this->assertJsonContains([
            '@context' => '/api/contexts/Bottle',
            '@type' => 'Bottle',
            'name' => 'Grange',
            'estateName' => 'Penfolds',
            'year' => 2018,
            'grapeVarieties' => ['Syrah'],
            'wineType' => 'red',
            'rate' => 'xs',
            'country' => 'France',
            'price' => 620,
        ]);
    }

    #[DataProvider('provideInvalidData')]
    public function testUpdateBottleWithInvalidData(
        string $id,
        array $payload,
        int $statusCode,
        array $violations,
    ): void {
        $this->put(
            sprintf('/api/bottles/%s', $id),
            $payload,
        );

        $this->assertResponseStatusCodeSame($statusCode);

        if ($statusCode === 422) {
            $this->assertJsonContains([
                'violations' => $violations,
            ]);
        }
    }

    public static function provideInvalidData(): \Generator
    {
        yield 'Not found bottle' => [
            'id' => '430e1ce0-f5a6-4503-bb44-3b3bcc6a9e1c',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Syrah'],
                'wineType' => 'red',
                'rate' => 'xs',
                'country' => 'France',
                'price' => 620.00,
            ],
            'statusCode' => 404,
            'violations' => [],
        ];

        yield 'BottleInventory not owned by user which try to update it' => [
            'id' => '97102d4c-da46-4105-8c34-53f5a2e1e9fa',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Syrah'],
                'wineType' => 'red',
                'rate' => 'xs',
                'country' => 'France',
                'price' => 620.00,
            ],
            'statusCode' => 403,
            'violations' => [],
        ];

        yield 'BottleInventory update without data' => [
            'id' => '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'payload' => [
                'name' => null,
                'estateName' => null,
                'wineType' => null,
                'year' => null,
                'grapeVarieties' => null,
                'rate' => null,
            ],
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
            ],
        ];

        yield 'Bad wine type value' => [
            'id' => '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Syrah'],
                'wineType' => 'yellow',
                'rate' => 'xs',
                'country' => 'France',
                'price' => 620.00,
            ],
            'statusCode' => 400,
            'violations' => [],
        ];

        yield 'Bad rate value' => [
            'id' => '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Syrah'],
                'wineType' => 'red',
                'rate' => 'top',
                'country' => 'France',
                'price' => 620.00,
            ],
            'statusCode' => 400,
            'violations' => [],
        ];

        yield 'One grape varieties doesn\'t exist' => [
            'id' => '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Riesling', 'Merlot', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'xs',
                'country' => 'France',
                'price' => 620.00,
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
            'id' => '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Riesling', 'Négrette', 'Cabernet Franc', 'Petit Verdot'],
                'wineType' => 'red',
                'rate' => 'xs',
                'country' => 'France',
                'price' => 620.00,
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
            'id' => '7bd55df3-e53c-410b-83a4-8e5ed9bcd50d',
            'payload' => [
                'name' => 'Grange',
                'estateName' => 'Penfolds',
                'year' => 2018,
                'grapeVarieties' => ['Syrah'],
                'wineType' => 'red',
                'rate' => 'xs',
                'country' => 'Italy',
                'price' => 620.00,
            ],
            'statusCode' => 422,
            'violations' => [
                [
                    'propertyPath' => 'country',
                    'message' => "Le pays avec le nom Italy n'existe pas.",
                ],
            ],
        ];
    }
}
