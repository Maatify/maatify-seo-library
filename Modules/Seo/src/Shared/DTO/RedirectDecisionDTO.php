<?php

declare(strict_types=1);

namespace Maatify\Seo\Shared\DTO;

use Maatify\Seo\Exception\SeoInvalidArgumentException;

final readonly class RedirectDecisionDTO implements \JsonSerializable
{
    public function __construct(
        public bool $matched,
        public ?int $httpStatus = null,
        public ?string $entityType = null,
        public ?int $languageId = null,
        public ?string $requestedSlug = null,
        public ?string $targetEntityType = null,
        public ?string $targetEntityId = null,
        public ?string $targetUrl = null,
    ) {
        if ($this->httpStatus !== null && $this->httpStatus !== 301 && $this->httpStatus !== 410) {
            throw SeoInvalidArgumentException::invalidHttpStatus($this->httpStatus);
        }
        if ($this->languageId !== null && $this->languageId < 1) {
            throw SeoInvalidArgumentException::invalidId('languageId');
        }
        if ($this->entityType !== null && trim($this->entityType) === '') {
            throw SeoInvalidArgumentException::emptyField('entityType');
        }
        if ($this->requestedSlug !== null && trim($this->requestedSlug) === '') {
            throw SeoInvalidArgumentException::emptyField('requestedSlug');
        }
        if ($this->targetEntityType !== null && trim($this->targetEntityType) === '') {
            throw SeoInvalidArgumentException::emptyField('targetEntityType');
        }
        if ($this->targetEntityId !== null && trim($this->targetEntityId) === '') {
            throw SeoInvalidArgumentException::emptyField('targetEntityId');
        }
        if ($this->targetUrl !== null && trim($this->targetUrl) === '') {
            throw SeoInvalidArgumentException::emptyField('targetUrl');
        }
        if ($this->matched && $this->httpStatus === null) {
            throw SeoInvalidArgumentException::emptyField('httpStatus');
        }
    }

    public static function none(string $entityType, int $languageId, string $requestedSlug): self
    {
        return new self(
            matched: false,
            entityType: trim($entityType),
            languageId: $languageId,
            requestedSlug: trim($requestedSlug),
        );
    }

    public static function fromRedirect(RedirectDTO $redirect, ?string $targetUrl = null): self
    {
        return new self(
            matched: true,
            httpStatus: $redirect->httpStatus,
            entityType: $redirect->entityType,
            languageId: $redirect->languageId,
            requestedSlug: $redirect->requestedSlug,
            targetEntityType: $redirect->targetEntityType,
            targetEntityId: $redirect->targetEntityId,
            targetUrl: $targetUrl,
        );
    }

    /** @return array<string, mixed> */
    public function jsonSerialize(): array
    {
        return [
            'matched' => $this->matched,
            'http_status' => $this->httpStatus,
            'entity_type' => $this->entityType,
            'language_id' => $this->languageId,
            'requested_slug' => $this->requestedSlug,
            'target_entity_type' => $this->targetEntityType,
            'target_entity_id' => $this->targetEntityId,
            'target_url' => $this->targetUrl,
        ];
    }
}
