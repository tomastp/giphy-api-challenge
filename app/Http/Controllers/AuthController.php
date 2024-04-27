<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Exception;
use App\Http\Requests\LoginPostRequest;
use Illuminate\Http\JsonResponse;
use Src\Shared\Infrastructure\LaravelLogguer;
use Src\User\Application\Exceptions\UnauthorizedException;
use Src\User\Application\LoginUseCase;
use Src\User\Domain\UserEmail;
use Src\User\Domain\UserPassword;
use Src\User\Infrastructure\AuthTokenProvider;

class AuthController extends Controller
{
    public function login(LoginPostRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();
            $useCase = new LoginUseCase(
                new AuthTokenProvider()
            );

            $token = $useCase->execute(
                new UserEmail($validated['email']),
                new UserPassword($validated['password'])
            );

            return new JsonResponse(['token' => $token], 200);
        }  catch (UnauthorizedException $e) {
            return new JsonResponse(['message' => $e->getMessage()], $e->getStatus());
        } catch (Exception $e) {
            LaravelLogguer::error('AuthController Exception: ', [$e]);
            return new JsonResponse(['message' => 'Internal Server Error'], 500);
        }
        
    }
}
