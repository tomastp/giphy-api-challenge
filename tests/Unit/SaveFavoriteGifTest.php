<?php

namespace Tests\Unit;

use Database\Seeders\UserSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Http;
use Src\Gif\Application\Exceptions\GifNotFoundException;
use Src\Gif\Application\Exceptions\UserNotExistException;
use Src\Gif\Application\SaveFavoriteUseCase;
use Src\Gif\Application\SearchByIdUseCase;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\GifAlias;
use Src\Gif\Domain\UserId;
use Src\Gif\Infrastructure\ApiClients\GiphyApiClient;
use Src\Gif\Infrastructure\EloquentGifRepository;
use Src\Gif\Infrastructure\EloquentUserRepository;
use Src\Gif\Infrastructure\GifProvider;
use Tests\TestCase;

class SaveFavoriteGifest extends TestCase
{

    use RefreshDatabase;

    public function test_use_case_save_favorite_gif_returns_ok(): void
    {
        $this->seed(UserSeeder::class);

        $json = json_decode(file_get_contents('tests/Fixtures/valid_search_gif_id.json'),true);

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response($json, 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SaveFavoriteUseCase(
            new EloquentGifRepository(),
            new SearchByIdUseCase($provider),
            new EloquentUserRepository
        );

        $gifStringId = 'GVaknm5baLdAc';
        $gifStringAlias = 'test';
        $gifUserId = 1;
        $gif = $useCase->execute(
            new GiphyId($gifStringId),
            new UserId($gifUserId),
            new GifAlias($gifStringAlias)
        );

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('favorites_gifs', 1);

        $this->assertEquals($gifStringId, $gif['gif_id']);
        $this->assertEquals($gifStringAlias, $gif['alias']);
        $this->assertEquals($json['data']['url'], $gif['url']);
        $this->assertEquals($gifUserId, $gif['user_id']);

    }

    public function test_use_case_save_favorite_gif_fails_gif_not_found(): void
    {
        $this->seed(UserSeeder::class);

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response(['data' => []], 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SaveFavoriteUseCase(
            new EloquentGifRepository(),
            new SearchByIdUseCase($provider),
            new EloquentUserRepository
        );

        $gifStringId = 'asdas';
        $gifStringAlias = 'test';
        $gifUserId = 1;

        $this->expectException(GifNotFoundException::class);

        $gif = $useCase->execute(
            new GiphyId($gifStringId),
            new UserId($gifUserId),
            new GifAlias($gifStringAlias)
        );

        $this->expectExceptionMessage('Gif ID not found.');

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseCount('favorites_gifs', 0);
    }

    public function test_use_case_save_favorite_gif_fails_user_not_exist(): void
    {
        $json = json_decode(file_get_contents('tests/Fixtures/valid_search_gif_id.json'),true);

        Http::fake([
            'api.giphy.com/v1/gifs/*' => Http::response($json, 200)
        ]);

        $provider = new GifProvider(
            new GiphyApiClient()
        );

        $useCase = new SaveFavoriteUseCase(
            new EloquentGifRepository(),
            new SearchByIdUseCase($provider),
            new EloquentUserRepository
        );

        $gifStringId = 'GVaknm5baLdAc';
        $gifStringAlias = 'test';
        $gifUserId = 1;

        $this->expectException(UserNotExistException::class);

        $gif = $useCase->execute(
            new GiphyId($gifStringId),
            new UserId($gifUserId),
            new GifAlias($gifStringAlias)
        );

        $this->expectExceptionMessage('User does not exist.');
    }


}

