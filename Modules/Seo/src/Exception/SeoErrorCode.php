<?php

declare(strict_types=1);

namespace Maatify\Seo\Exception;

final class SeoErrorCode
{
    public const int INVALID_EMPTY_FIELD = 1001;
    public const int INVALID_ID = 1002;
    public const int NOT_FOUND_BY_ID = 2001;
    public const int NOT_FOUND_BY_CODE = 2002;
    public const int CODE_ALREADY_EXISTS = 3001;
    public const int CONFLICT_GENERIC = 4001;
}
