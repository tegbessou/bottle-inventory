<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\State\Processor;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use ApiPlatform\Validator\Exception\ValidationException;
use EmpireDesAmis\BottleInventory\Application\Command\UpdateBottleCommand;
use EmpireDesAmis\BottleInventory\Application\Query\GetBottleQuery;
use EmpireDesAmis\BottleInventory\Domain\Enum\Rate;
use EmpireDesAmis\BottleInventory\Domain\Enum\WineType;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleCountryDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\BottleGrapeVarietiesDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\UpdateBottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\UpdateBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\GetBottleResource;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\PutBottleResource;
use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Validator\ConstraintViolation\BuildCountryDoesntExistConstraintViolation;
use EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Validator\ConstraintViolation\BuildGrapeVarietiesDoesntExistConstraintViolation;
use Monolog\Attribute\WithMonologChannel;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TegCorp\SharedKernelBundle\Application\Command\CommandBusInterface;
use TegCorp\SharedKernelBundle\Application\Query\QueryBusInterface;
use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

/**
 * @implements ProcessorInterface<GetBottleResource, void>
 */
#[WithMonologChannel('bottle_inventory')]
final readonly class PutBottleProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private BuildCountryDoesntExistConstraintViolation $buildCountryDoesntExistConstraintViolation,
        private BuildGrapeVarietiesDoesntExistConstraintViolation $buildGrapeVarietiesDoesntExistConstraintViolation,
        private LoggerInterface $logger,
        private QueryBusInterface $queryBus,
    ) {
    }

    #[\Override]
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): PutBottleResource
    {
        Assert::isInstanceOf($data, PutBottleResource::class);
        Assert::notNull($uriVariables['id']);
        Assert::uuid($uriVariables['id']);
        Assert::notNull($data->name);
        Assert::notNull($data->estateName);
        Assert::notNull($data->wineType);
        Assert::isInstanceOf($data->wineType, WineType::class);
        Assert::notNull($data->year);
        Assert::year($data->year);
        Assert::notNull($data->grapeVarieties);
        Assert::notNull($data->rate);
        Assert::isInstanceOf($data->rate, Rate::class);

        try {
            $this->commandBus->dispatch(
                new UpdateBottleCommand(
                    $uriVariables['id'],
                    $data->name,
                    $data->estateName,
                    $data->wineType->value,
                    $data->year,
                    $data->grapeVarieties,
                    $data->rate->value,
                    $data->country,
                    $data->price
                ),
            );
        } catch (UpdateBottleDoesntExistException $exception) {
            $this->logger->error(
                'Patch bottle: Bottle doesn\'t exist found',
                [
                    'bottleId' => $exception->bottleId,
                ],
            );

            throw new NotFoundHttpException();
        } catch (UpdateBottleNotAuthorizeForThisUserException) {
            $this->logger->error(
                'Patch bottle: User not authorized to update this bottle',
            );

            throw new AccessDeniedHttpException();
        } catch (BottleCountryDoesntExistException $exception) {
            $this->logger->error(
                'Patch bottle: Country doesn\'t exist',
                [
                    'bottleId' => $exception->country,
                ],
            );

            throw new ValidationException($this->buildCountryDoesntExistConstraintViolation->build($exception->country));
        } catch (BottleGrapeVarietiesDoesntExistException $exception) {
            $this->logger->error(
                'Patch bottle: Grape varieties doesn\'t exist',
                [
                    'bottleId' => $exception->grapeVarieties,
                ],
            );

            throw new ValidationException($this->buildGrapeVarietiesDoesntExistConstraintViolation->build($exception->grapeVarieties));
        }

        $bottle = $this->queryBus->ask(
            new GetBottleQuery($uriVariables['id'])
        );

        if ($bottle === null) {
            throw new \LogicException();
        }

        return PutBottleResource::fromModel($bottle);
    }
}
