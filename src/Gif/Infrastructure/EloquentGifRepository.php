<?php 

declare(strict_types = 1);

namespace Src\Gif\Infrastructure;

use App\Gif;
use Src\Gif\Domain\Contracts\GifRepository;
use Src\Gif\Domain\GiphyId;
use Src\Gif\Domain\GifEntity;
use Src\Gif\Domain\UserId;

final class EloquentGifRepository implements GifRepository
{

    private Gif $eloquentModel;

    public function __construct()
    {
        $this->eloquentModel = new Gif();
    }

    public function save(GifEntity $entity): array
    {
        $this->eloquentModel->fill($entity->toArray());
            $this->eloquentModel->save();
            return $this->eloquentModel->toArray();
    }

    public function search(GiphyId $giphyId): array
    {
        return $this->eloquentModel->findOrFail($giphyId->getValue())->toArray();
    }

    public function findByGifIdAndUser(GiphyId $giphyId, UserId $userId): array
    {
        $collection = $this->eloquentModel::where('gif_id', $giphyId->getValue())
            ->where('user_id', $userId->getValue())
            ->get();
        if ($collection->count() > 0) {
            return $collection->first()->toArray();
        }
        return [];
    }
}