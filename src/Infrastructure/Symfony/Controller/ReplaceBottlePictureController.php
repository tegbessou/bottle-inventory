<?php

declare(strict_types=1);

namespace EmpireDesAmis\BottleInventory\Infrastructure\Symfony\Controller;

use EmpireDesAmis\BottleInventory\Application\Command\ReplaceBottlePictureCommand;
use EmpireDesAmis\BottleInventory\Application\Query\GetBottleQuery;
use EmpireDesAmis\BottleInventory\Domain\Exception\ReplaceBottlePictureBottleDoesntExistException;
use EmpireDesAmis\BottleInventory\Domain\Exception\UpdateBottleNotAuthorizeForThisUserException;
use EmpireDesAmis\BottleInventory\Infrastructure\ApiPlatform\Resource\GetBottleResource;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use TegCorp\SharedKernelBundle\Application\Command\CommandBusInterface;
use TegCorp\SharedKernelBundle\Application\Query\QueryBusInterface;
use TegCorp\SharedKernelBundle\Infrastructure\Webmozart\Assert;

#[AsController]
final class ReplaceBottlePictureController extends AbstractController
{
    public function __construct(
        private readonly CommandBusInterface $commandBus,
        private readonly QueryBusInterface $queryBus,
    ) {
    }

    public function __invoke(Request $request): JsonResponse
    {
        $id = $request->attributes->get('id');

        Assert::uuid($id);
        Assert::picture($request->files->get('picture')->getClientOriginalName());

        try {
            $this->commandBus->dispatch(
                new ReplaceBottlePictureCommand(
                    $id,
                    $request->files->get('picture')->getPathname(),
                    $request->files->get('picture')->getClientOriginalName(),
                ),
            );
        } catch (ReplaceBottlePictureBottleDoesntExistException) {
            throw new NotFoundHttpException();
        } catch (UpdateBottleNotAuthorizeForThisUserException) {
            throw new AccessDeniedHttpException();
        }

        $bottle = $this->queryBus->ask(
            new GetBottleQuery($id),
        );

        if ($bottle === null) {
            throw new \LogicException();
        }

        return new JsonResponse(GetBottleResource::fromModel($bottle));
    }
}
