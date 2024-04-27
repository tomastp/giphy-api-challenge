<?php

declare(strict_types=1);

namespace Src\Shared\Infrastructure;

use Illuminate\Support\Facades\Log;
use Src\Shared\Domain\Contracts\Logguer;

final class LaravelLogguer implements Logguer
{
    static public function info(string $message, array $context = []): void
    {
        Log::info($message, $context);
    }
    
    static public function debug(string $message, array $context = []): void
    {
        Log::debug($message, $context);
    }

    static public function warn(string $message, array $context = []): void
    {
        Log::warning($message, $context);
    }

    static public function error(string $message, array $context = []): void
    {
        Log::error($message, $context);
    }

}
