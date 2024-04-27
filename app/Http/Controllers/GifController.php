<?php

declare(strict_types = 1);

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Requests\FavoriteGifPostRequest;
use Src\Gif\Infrastructure\ApiClients\GiphyApiClient;
use Src\Gif\Infrastructure\EloquentGifRepository;
use Src\Gif\Infrastructure\Exceptions\BadRequestException;
use Src\Gif\Infrastructure\GifProvider;
use Src\Gif\Application\Exceptions\GifAlreadyExistException;
use Src\Gif\Application\Exceptions\GifNotFoundException;
use Src\Gif\Application\Exceptions\UserNotExistException;
use Src\Gif\Application\SaveFavoriteUseCase;
use Src\Gif\Application\SearchByIdUseCase;
use Src\Gif\Application\SearchByQueryUseCase;
use Src\Gif\Domain\GifAlias;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\GifQueryParams;
use Src\Gif\Domain\UserId;
use Src\Gif\Infrastructure\EloquentUserRepository;
use Src\Gif\Infrastructure\Exceptions\ApiClientException;
use Src\Shared\Infrastructure\LaravelLogguer;

class GifController extends Controller
{

    public function get(Request $request)
    {
        try {
            $query  = $request->query('query');
            $limit  = $request->query('limit');
            $offset = $request->query('offset');

            if (!$query) throw new BadRequestException();

            $provider = new GifProvider( new GiphyApiClient() );
            $useCase = new SearchByQueryUseCase($provider);

            $filter  = new GifQueryParams( query: $query, offset: $offset, limit: $limit);
            
            $gifs = $useCase->execute($filter);

            return new JsonResponse($gifs, 200);
        } catch (BadRequestException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (ApiClientException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (Exception $e) {
            LaravelLogguer::error('GifController Exception: ', [$e]);
            return new JsonResponse(['message' => 'Internal Server Error'], 500);
        }
    }

    public function find(Request $request, string $id)
    {
        try {
            $provider = new GifProvider( new GiphyApiClient() );
            $useCase = new SearchByIdUseCase($provider);
            $idObj = new GiphyId($id);
            
            $gif = $useCase->execute($idObj);

            return new JsonResponse($gif, 200);
        } catch (GifNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (ApiClientException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (Exception $e) {
            LaravelLogguer::error('GifController Exception: ', [$e]);
            return new JsonResponse(['message' => 'Internal Server Error'], 500);
        }
    }

    public function storeFavorite(FavoriteGifPostRequest $request)
    {
        try {
            $validated = $request->validated();
            $provider = new GifProvider( new GiphyApiClient() );
            $useCaseFind = new SearchByIdUseCase($provider);
            $useCase = new SaveFavoriteUseCase(
                new EloquentGifRepository(),
                $useCaseFind,
                new EloquentUserRepository
            );
            $gif_id = new GiphyId($validated['gif_id']);
            $alias = new GifAlias($validated['alias']);
            $user_id = new UserId((int) $validated['user_id']);
            
            $gif = $useCase->execute($gif_id, $user_id, $alias);

            return new JsonResponse($gif, 201);
        } catch (GifNotFoundException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (GifAlreadyExistException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (UserNotExistException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (Exception $e) {
            LaravelLogguer::error('GifController Exception: ', [$e]);
            return new JsonResponse(['message' => 'Internal Server Error'], 500);
        }
        
    }
}
