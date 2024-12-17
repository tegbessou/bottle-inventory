<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\DrivingTest\BottleInventory\Infrastructure\ApiPlatform\State\Provider;

use EmpireDesAmis\BottleInventory\Tests\Shared\ApiTestCase;

final class GetBottleProviderTest extends ApiTestCase
{
    public function testGet(): void
    {
        $this->get('/api/bottles/3a28deee-f221-4aa1-800b-6b5b27137bfc');

        $this->assertResponseIsSuccessful();
        $this->assertJsonContains([
            '@context' => '/api/contexts/Bottle',
        ]);
    }

    public function testGetNotFound(): void
    {
        $this->get('/api/bottles/d7791659-8a66-421c-a87b-b562d863bdae');

        $this->assertResponseStatusCodeSame(404);
    }
}
