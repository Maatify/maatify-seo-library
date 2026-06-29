<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\Service;

use Maatify\Seo\Exception\SeoNotFoundException;
use Maatify\Seo\Shared\Contract\RedirectRepositoryInterface;
use Maatify\Seo\Shared\DTO\RedirectDTO;

final readonly class RedirectQueryService
{
    public function __construct(private RedirectRepositoryInterface $repository)
    {
    }

    public function getById(int $id): RedirectDTO
    {
        $redirect = $this->repository->findById($id);

        if ($redirect === null) {
            throw SeoNotFoundException::withId($id);
        }

        return $redirect;
    }

    public function getActiveByRequestedSlug(string $entityType, int $languageId, string $requestedSlug): RedirectDTO
    {
        $redirect = $this->repository->findActiveByRequestedSlug($entityType, $languageId, $requestedSlug);

        if ($redirect === null) {
            throw SeoNotFoundException::withCode($entityType . ':' . (string) $languageId . ':' . $requestedSlug);
        }

        return $redirect;
    }
}
