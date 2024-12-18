<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php82\Rector\Class_\ReadOnlyClassRector;
use Rector\TypeDeclaration\Rector\ClassMethod\AddVoidReturnTypeWhereNoReturnRector;

return RectorConfig::configure()
    ->withPaths([
        __DIR__.'/config',
        __DIR__.'/fixtures',
        __DIR__.'/public',
        __DIR__.'/src',
        __DIR__.'/tests',
    ])
    ->withPhpSets(true)
    ->withRules([
        AddVoidReturnTypeWhereNoReturnRector::class,
    ])
    ->withSkip([
        ReadOnlyClassRector::class => [
            __DIR__.'/src/Infrastructure/Doctrine/Entity/Bottle.php',
            __DIR__.'/src/Infrastructure/Doctrine/Entity/GrapeVariety.php',
            __DIR__.'/src/Application/ReadModel/Bottle.php',
            __DIR__.'/src/Application/ReadModel/GrapeVariety.php',
        ],
    ]);
