<?php

declare(strict_types=1);

namespace Src\Gif\Domain\Contracts;


interface ApiClient
{
    public function get(string $query): array;
    public function getById(string $id): array;
}