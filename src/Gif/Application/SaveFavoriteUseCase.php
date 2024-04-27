<?php

declare(strict_types=1);

namespace Src\Gif\Application;

use Src\Gif\Application\Exceptions\GifAlreadyExistException;
use Src\Gif\Application\Exceptions\GifNotFoundException;
use Src\Gif\Application\Exceptions\UserNotExistException;
use Src\Gif\Domain\Contracts\GifRepository;
use Src\Gif\Domain\Contracts\UserRepository;
use Src\Gif\Domain\GifAlias;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\GifEntity;
use Src\Gif\Domain\UserId;

final class SaveFavoriteUseCase
{
    private SearchByIdUseCase $finder;
    private GifRepository $repository;
    private UserRepository $userRepository;


    public function __construct(
        GifRepository $repository,
        SearchByIdUseCase $useCaseFind,
        UserRepository $userRepository
    ) {
        $this->finder = $useCaseFind;
        $this->repository = $repository;
        $this->userRepository = $userRepository;

    }

    public function execute(GiphyId $id, UserId $user_id, GifAlias $alias)
    {
        $gif = $this->finder->execute($id);
        if(count($gif) === 0) throw new GifNotFoundException();

        $exist = $this->repository->findByGifIdAndUser( giphyId: $id, userId: $user_id);
        if(count($exist) > 0) throw new GifAlreadyExistException();
        
        $userExist = $this->userRepository->findById($user_id);
        if(count($userExist) === 0) throw new UserNotExistException();

        $entity = new GifEntity(
            id: null,
            gif_id: $id->getValue(),
            alias: $alias->getValue(),
            url: $gif['url'],
            slug: $gif['slug'],
            title: $gif['title'],
            user_id: $user_id->getValue()
        );

        return $this->repository->save($entity);
    }
}