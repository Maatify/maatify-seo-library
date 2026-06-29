<?php

declare(strict_types=1);

namespace Maatify\Seo\Admin\SeoOverride\DTO;

final readonly class SeoOverrideDTO
{
    public function __construct(
        public int $id,
        public string $entityType,
        public string $entityId,
        public int $languageId,
        public ?string $metaTitle,
        public ?string $metaDescription,
        public string $createdAt,
        public string $updatedAt,
        public ?string $deletedAt,
    ) {
    }
}
