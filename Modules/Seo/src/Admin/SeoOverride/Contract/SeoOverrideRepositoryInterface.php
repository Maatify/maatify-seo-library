<?php

declare(strict_types=1);

namespace Maatify\Seo\Admin\SeoOverride\Contract;

use Maatify\Seo\Admin\SeoOverride\Command\CreateSeoOverrideCommand;
use Maatify\Seo\Admin\SeoOverride\Command\UpdateSeoOverrideCommand;
use Maatify\Seo\Admin\SeoOverride\DTO\SeoOverrideDTO;

interface SeoOverrideRepositoryInterface
{
    public function create(CreateSeoOverrideCommand $command): int;
    public function update(UpdateSeoOverrideCommand $command): bool;
    public function findById(int $id): ?SeoOverrideDTO;
    public function findActiveForEntity(string $entityType, string $entityId, int $languageId): ?SeoOverrideDTO;
    public function softDelete(int $id): bool;
    public function hardDelete(int $id): bool;
}
