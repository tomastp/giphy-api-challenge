<?php

namespace Tests\Unit;

use Illuminate\Support\Facades\Http;
use Src\Gif\Application\Exceptions\GifNotFoundException;
use Src\Gif\Application\SearchByIdUseCase;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Infrastructure\ApiClients\GiphyApiClient;
use Src\Gif\Infrastructure\GifProvider;
use Tests\TestCase;

class SearchByIdTest extends TestCase
{
    public function test_use_case_search_by_id_returns_ok(): void
    {
        $json = json_decode(file_get_contents('tests/Fixtures/valid_search_gif_id.json'),true);

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response($json, 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SearchByIdUseCase($provider);

        $id = new GiphyId('GVaknm5baLdAc');
        
        $gif = $useCase->execute($id);

        $this->assertIsString($gif['id']);
        $this->assertIsString($gif['url']);
        $this->assertMatchesRegularExpression('/giphy.com/', $gif['url']);

    }

    public function test_use_case_search_by_id_throws_exception(): void
    {
        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response(['data' => []], 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SearchByIdUseCase($provider);

        $id = new GiphyId('zaraza');
        
        $this->expectException(GifNotFoundException::class);

        $gif = $useCase->execute($id);

        $this->expectExceptionMessage('Gif ID not found.');

    }

}

