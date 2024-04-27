<?php

declare(strict_types = 1);

namespace Src\User\Application;

use Src\User\Domain\Contracts\AuthProvider;
use Src\User\Domain\UserEmail;
use Src\User\Domain\UserPassword;

final class LoginUseCase {

    private AuthProvider $provider;

    public function __construct(AuthProvider $provider)
    {
        $this->provider = $provider;
    }

    public function execute(UserEmail $email, UserPassword $password)
    {
        return $this->provider->createToken(
            $email->getValue(),
            $password->getValue()
        );
    }

}
