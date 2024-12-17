<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Infrastructure\ApiPlatform\State\Processor;

use EmpireDesAmis\BottleInventory\Tests\Shared\ApiTestCase;
use EmpireDesAmis\BottleInventory\Tests\Shared\RefreshDatabase;
use PHPUnit\Framework\Attributes\DataProvider;

final class DeleteBottleProcessorTest extends ApiTestCase
{
    use RefreshDatabase;

    public function testDeleteBottle(): void
    {
        $this->delete('/api/bottles/7bd55df3-e53c-410b-83a4-8e5ed9bcd50d');

        $this->assertResponseStatusCodeSame(204);
    }

    #[DataProvider('provideInvalidData')]
    public function testDeleteBottleWithInvalidData(
        string $id,
        int $statusCode,
    ): void {
        $this->delete(
            sprintf(
                '/api/bottles/%s',
                $id,
            ),
        );
        $this->assertResponseStatusCodeSame($statusCode);
    }

    public static function provideInvalidData(): \Generator
    {
        yield 'Not found bottle' => [
            'id' => '430e1ce0-f5a6-4503-bb44-3b3bcc6a9e1c',
            'statusCode' => 404,
        ];

        yield 'BottleInventory not owned by user which try to delete it' => [
            'id' => '97102d4c-da46-4105-8c34-53f5a2e1e9fa',
            'statusCode' => 403,
        ];
    }
}
