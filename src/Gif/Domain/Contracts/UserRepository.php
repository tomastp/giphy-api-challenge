<?php

declare(strict_types=1);

namespace Src\Gif\Domain\Contracts;

use Src\Gif\Domain\UserId;

interface UserRepository
{
    public function findById(UserId $userId): array;
}