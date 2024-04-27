<?php

declare(strict_types=1);

namespace Src\Shared\Domain\Contracts;

interface  Logguer {
    static public function info(string $message, array $context): void;
    static public function debug(string $message, array $context): void;
    static public function warn(string $message, array $context): void;
    static public function error(string $message, array $context): void;
}