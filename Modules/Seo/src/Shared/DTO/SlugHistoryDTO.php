<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\DTO;

final readonly class SlugHistoryDTO
{
    public function __construct(
        public int $id,
        public string $entityType,
        public string $entityId,
        public int $languageId,
        public string $oldSlug,
        public string $createdAt,
        public ?string $deletedAt,
    ) {
    }
}
