<?php 

declare(strict_types = 1);

namespace Src\Gif\Infrastructure;

use Src\Gif\Domain\Contracts\ApiClient;
use Src\Gif\Domain\Contracts\GifApiProvider;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\GifQueryParams;

final class GifProvider implements GifApiProvider
{

    private ApiClient $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    public function searchQuery(GifQueryParams $params): array
    {
        $queryParams = $params->getQueryString();
        return $this->client->get($queryParams);
    }

    public function searchId(GiphyId $id): array
    {
        return $this->client->getById($id->getValue());
    }
}