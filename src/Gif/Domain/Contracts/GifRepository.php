<?php

declare(strict_types=1);

namespace Src\Gif\Domain\Contracts;


use Src\Gif\Domain\GifEntity;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\UserId;

interface GifRepository
{
    public function search(GiphyId $giphyId): array;
    public function findByGifIdAndUser(GiphyId $giphyId, UserId $userId): array;
    public function save(GifEntity $gif): array;
}