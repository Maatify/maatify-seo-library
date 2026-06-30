<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\Service;

use Maatify\Seo\Shared\Command\CreateSlugHistoryCommand;
use Maatify\Seo\Shared\Command\RecordSlugChangeCommand;
use Maatify\Seo\Shared\DTO\SlugHistoryDTO;

final readonly class SlugHistoryService
{
    public function __construct(
        private SlugHistoryQueryService $queryService,
        private SlugHistoryCommandService $commandService,
    ) {
    }

    public function recordChange(RecordSlugChangeCommand $command): ?int
    {
        if (! $command->hasChanged()) {
            return null;
        }

        return $this->commandService->create(new CreateSlugHistoryCommand(
            entityType: $command->entityType,
            entityId: $command->entityId,
            languageId: $command->languageId,
            oldSlug: $command->oldSlug,
        ));
    }

    public function findActiveBySlug(string $entityType, int $languageId, string $oldSlug): SlugHistoryDTO
    {
        return $this->queryService->getActiveBySlug($entityType, $languageId, $oldSlug);
    }

    /** @return list<SlugHistoryDTO> */
    public function findActiveForEntity(string $entityType, string $entityId, int $languageId): array
    {
        return $this->queryService->getActiveForEntity($entityType, $entityId, $languageId);
    }
}
