<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Domain\ValueObject;

use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

final readonly class BottlePicture
{
    private string $path;

    public function __construct(
        string $path,
    ) {
        Assert::string($path);
        Assert::lengthBetween($path, 1, 255);
        Assert::picture($path);

        $this->path = $path;
    }

    public static function fromString(
        string $path,
    ): self {
        return new self($path);
    }

    public function path(): ?string
    {
        return $this->path ?? null;
    }
}
