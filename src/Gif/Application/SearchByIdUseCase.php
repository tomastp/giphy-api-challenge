<?php

declare(strict_types=1);

namespace Src\Gif\Application;

use Src\Gif\Application\Exceptions\GifNotFoundException;
use Src\Gif\Domain\Contracts\GifApiProvider;
use Src\Gif\Domain\GiphyId;

final class SearchByIdUseCase
{
    private GifApiProvider $provider;

    public function __construct(GifApiProvider $provider) {
        $this->provider = $provider;
    }

    public function execute(GiphyId $id)
    {
        $gif = $this->provider->searchId($id);
        if (!$gif) throw new GifNotFoundException();
        return $gif;

    }
}