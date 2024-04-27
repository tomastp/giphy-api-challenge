<?php

declare(strict_types=1);

namespace Src\User\Domain\Contracts;

interface AuthProvider
{
    public function createToken(string $email, string $password): string;
}
