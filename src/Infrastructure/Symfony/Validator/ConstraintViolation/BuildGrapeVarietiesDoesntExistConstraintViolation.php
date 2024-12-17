<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Validator\ConstraintViolation;

use Symfony\Component\Validator\ConstraintViolation;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Contracts\Translation\TranslatorInterface;

final readonly class BuildGrapeVarietiesDoesntExistConstraintViolation
{
    public function __construct(
        private TranslatorInterface $translator,
    ) {
    }

    public function build(array $grapeVarieties): ConstraintViolationList
    {
        $grapeVarietiesString = implode(', ', $grapeVarieties);

        $violations = new ConstraintViolationList();
        $violations->add(new ConstraintViolation(
            $this->translator->trans(
                'bottle_inventory.grape_varieties.doesnt_exist',
                ['grapeVarieties' => count($grapeVarieties), 'grapeVarietiesString' => $grapeVarietiesString],
                'validators',
            ),
            null,
            [],
            $grapeVarietiesString,
            'grapeVarieties',
            $grapeVarietiesString
        ));

        return $violations;
    }
}
