<?php 

declare(strict_types = 1);

namespace Src\User\Infrastructure;

use App\User;
use Illuminate\Support\Facades\Auth;
use Src\User\Application\Exceptions\UnauthorizedException;
use Src\User\Domain\Contracts\AuthProvider;

final class AuthTokenProvider implements AuthProvider
{

    public function createToken(string $email, string $password): string
    {
        if(Auth::attempt(['email' => $email, 'password' => $password])) {
            /** @var User */
            $user = Auth::user();
            return $user->createToken('Api')->accessToken;
        }
        throw new UnauthorizedException();
    }
}