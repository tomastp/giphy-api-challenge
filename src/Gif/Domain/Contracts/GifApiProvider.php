<?php

declare(strict_types=1);

namespace Src\Gif\Domain\Contracts;

use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\GifQueryParams;

interface GifApiProvider
{
    public function searchQuery(GifQueryParams $query): array;
    public function searchId(GiphyId $id): array;
}