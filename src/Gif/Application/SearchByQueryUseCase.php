<?php

declare(strict_types=1);

namespace Src\Gif\Application;

use Src\Gif\Domain\Contracts\GifApiProvider;
use Src\Gif\Domain\GifQueryParams;

final class SearchByQueryUseCase
{

    private GifApiProvider $provider;

    public function __construct(GifApiProvider $provider) {
        $this->provider = $provider;
    }
    
    public function execute(GifQueryParams $params)
    {
        return $this->provider->searchQuery($params);
    }
}