<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\Service;

use Maatify\Seo\Exception\SeoNotFoundException;
use Maatify\Seo\Shared\Command\CreateRedirectCommand;
use Maatify\Seo\Shared\Command\ResolveRedirectCommand;
use Maatify\Seo\Shared\Contract\HostUrlGeneratorInterface;
use Maatify\Seo\Shared\DTO\RedirectDecisionDTO;
use Maatify\Seo\Shared\DTO\RedirectDTO;

final readonly class RedirectManagerService
{
    public function __construct(
        private RedirectQueryService $queryService,
        private RedirectCommandService $commandService,
        private ?HostUrlGeneratorInterface $urlGenerator = null,
    ) {
    }

    public function resolve(ResolveRedirectCommand $command): RedirectDecisionDTO
    {
        try {
            $redirect = $this->queryService->getActiveByRequestedSlug(
                $command->entityType,
                $command->languageId,
                $command->requestedSlug,
            );
        } catch (SeoNotFoundException) {
            return RedirectDecisionDTO::none(
                $command->entityType,
                $command->languageId,
                $command->requestedSlug,
            );
        }

        return RedirectDecisionDTO::fromRedirect(
            $redirect,
            $this->resolveTargetUrl($redirect),
        );
    }

    public function createPermanentRedirect(
        string $entityType,
        int $languageId,
        string $requestedSlug,
        string $targetEntityType,
        string $targetEntityId,
    ): int {
        return $this->commandService->create(new CreateRedirectCommand(
            entityType: $entityType,
            languageId: $languageId,
            requestedSlug: $requestedSlug,
            targetEntityType: $targetEntityType,
            targetEntityId: $targetEntityId,
            httpStatus: 301,
        ));
    }

    public function createGoneRedirect(string $entityType, int $languageId, string $requestedSlug): int
    {
        return $this->commandService->create(new CreateRedirectCommand(
            entityType: $entityType,
            languageId: $languageId,
            requestedSlug: $requestedSlug,
            targetEntityType: null,
            targetEntityId: null,
            httpStatus: 410,
        ));
    }

    private function resolveTargetUrl(RedirectDTO $redirect): ?string
    {
        if ($this->urlGenerator === null || $redirect->httpStatus !== 301) {
            return null;
        }

        if ($redirect->targetEntityType === null || $redirect->targetEntityId === null) {
            return null;
        }

        return $this->urlGenerator->generateEntityUrl(
            $redirect->targetEntityType,
            $redirect->targetEntityId,
            $redirect->languageId,
            null,
        );
    }
}
