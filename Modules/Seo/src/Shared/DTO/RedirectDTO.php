<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\DTO;

final readonly class RedirectDTO
{
    public function __construct(
        public int $id,
        public string $entityType,
        public int $languageId,
        public string $requestedSlug,
        public ?string $targetEntityType,
        public ?string $targetEntityId,
        public int $httpStatus,
        public string $createdAt,
        public ?string $deletedAt,
    ) {
    }
}
