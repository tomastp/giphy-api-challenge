<?php

declare(strict_types = 1);

namespace Src\Gif\Domain;

final class UserId
{
    private int $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function getValue()
    {
        return $this->id;
    }
}
