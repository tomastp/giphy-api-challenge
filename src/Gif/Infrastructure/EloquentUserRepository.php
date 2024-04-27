<?php 

declare(strict_types = 1);

namespace Src\Gif\Infrastructure;

use App\User;
use Src\Gif\Domain\Contracts\UserRepository;
use Src\Gif\Domain\UserId;

final class EloquentUserRepository implements UserRepository
{

    private User $eloquentModel;

    public function __construct()
    {
        $this->eloquentModel = new User();
    }

    public function findById(UserId $userId): array
    {
        return $this->eloquentModel::where('id', $userId->getValue())->get()->toArray();
    }

}