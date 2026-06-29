<?php

declare(strict_types=1);

namespace Maatify\Seo\Admin\SeoOverride\Service;

use Maatify\Seo\Admin\SeoOverride\Contract\SeoOverrideRepositoryInterface;
use Maatify\Seo\Admin\SeoOverride\DTO\SeoOverrideDTO;
use Maatify\Seo\Exception\SeoNotFoundException;

final readonly class SeoOverrideQueryService
{
    public function __construct(private SeoOverrideRepositoryInterface $repository)
    {
    }

    public function getById(int $id): SeoOverrideDTO
    {
        $override = $this->repository->findById($id);

        if ($override === null) {
            throw SeoNotFoundException::withId($id);
        }

        return $override;
    }

    public function getActiveForEntity(string $entityType, string $entityId, int $languageId): SeoOverrideDTO
    {
        $override = $this->repository->findActiveForEntity($entityType, $entityId, $languageId);

        if ($override === null) {
            throw SeoNotFoundException::withCode($entityType . ':' . $entityId . ':' . (string) $languageId);
        }

        return $override;
    }
}
