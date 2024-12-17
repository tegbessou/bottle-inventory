<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Tests\AdapterTest\ContractTest\Infrastructure\Country\Http\Repository;

use EmpireDesAmis\BottleInventory\Domain\Adapter\CountryAdapterInterface;
use EmpireDesAmis\BottleInventory\Domain\ValueObject\CountryName;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

final class CountryHttpRepositoryTest extends KernelTestCase
{
    private CountryAdapterInterface $httpCountryRepository;

    #[\Override]
    protected function setUp(): void
    {
        self::bootKernel();
        $container = self::getContainer();

        $this->httpCountryRepository = $container->get(CountryAdapterInterface::class);
    }

    public function testExist(): void
    {
        $this->assertTrue(
            $this->httpCountryRepository->exist(CountryName::fromString('France')),
        );
    }

    public function testNotExist(): void
    {
        $this->assertFalse(
            $this->httpCountryRepository->exist(CountryName::fromString('Spain')),
        );
    }
}
