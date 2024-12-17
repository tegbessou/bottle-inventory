<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\OpenApi;

use ApiPlatform\Metadata\FilterInterface;
use Symfony\Component\PropertyInfo\Type;

final readonly class BottleFilter implements FilterInterface
{
    #[\Override]
    public function getDescription(string $resourceClass): array
    {
        return [
            'name' => [
                'property' => 'name',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
            'estateName' => [
                'property' => 'estateName',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
            'type' => [
                'property' => 'type',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
            'saveAt' => [
                'property' => 'tastedAt',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
            'year' => [
                'property' => 'year',
                'type' => Type::BUILTIN_TYPE_INT,
                'required' => false,
            ],
            'rate' => [
                'property' => 'rate',
                'type' => Type::BUILTIN_TYPE_STRING,
                'required' => false,
            ],
        ];
    }
}
