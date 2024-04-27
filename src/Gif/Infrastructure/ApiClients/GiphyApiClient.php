<?php

declare(strict_types = 1);

namespace Src\Gif\Infrastructure\ApiClients;

use Illuminate\Support\Facades\Http;
use Src\Gif\Domain\Contracts\ApiClient;
use Src\Gif\Application\Exceptions\GifNotFoundException;
use Src\Gif\Infrastructure\Exceptions\ApiClientException;

class GiphyApiClient implements ApiClient
{

    private string $endpoint;

    private string $key;

    public function __construct() {
        $this->endpoint = env('GIPHY_API_ENDPOINT', false);
        $this->key   = env('GIPHY_API_KEY', false);
    }

    public function getById(string $id): array
    {
        return $this->fetchCurl("/{$id}?api_key={$this->key}");
    }

    public function get(string $query): array
    {
        return $this->fetchCurl("/search?api_key={$this->key}&{$query}");
    }

    private function fetchCurl(string $url): array
    {
        $response = Http::get("{$this->endpoint}{$url}");
        switch ($response->getStatusCode()) {
            case 200:
                return $response->json()['data'];
            
            case 404:
                throw new GifNotFoundException();
        }
        throw new ApiClientException();
    }

}
