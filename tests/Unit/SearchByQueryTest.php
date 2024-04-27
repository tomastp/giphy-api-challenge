<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Src\Gif\Application\SearchByQueryUseCase;
use Src\Gif\Domain\GifQueryParams;
use Src\Gif\Infrastructure\ApiClients\GiphyApiClient;
use Src\Gif\Infrastructure\GifProvider;
use Tests\TestCase;

class SearchByQueryTest extends TestCase
{
    public function test_use_case_search_by_query_returns_200_10_records(): void
    {
        $json = json_decode(file_get_contents('tests/Fixtures/valid_search_gif_query.json'),true);

        Http::fake([
            'api.giphy.com/v1/gifs/search*' => Http::response($json, 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SearchByQueryUseCase($provider);

        $params = new GifQueryParams('cheseeburguer', 0, 10);
        
        $gifs = $useCase->execute($params);

        collect($gifs)->each(function ($item) {
            $this->assertIsString($item['id']);
            $this->assertIsString($item['url']);
            $this->assertMatchesRegularExpression('/giphy.com/', $item['url']);
        });

        $this->assertCount(10, $gifs);
    }

    public function test_use_case_search_by_query_returns_200_empty_records(): void
    {
        Http::fake([
            'api.giphy.com/v1/gifs/search*' => Http::response(['data' => []], 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SearchByQueryUseCase($provider);

        $params = new GifQueryParams('asdapoinjwerjob', 0, 10);
        
        $gifs = $useCase->execute($params);

        $this->assertCount(0, $gifs);
        $this->assertEmpty($gifs);
    }

}

