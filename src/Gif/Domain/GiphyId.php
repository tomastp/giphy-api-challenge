<?php

declare(strict_types = 1);

namespace Src\Gif\Domain;

final class GiphyId
{
    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function getValue()
    {
        return $this->id;
    }

}
