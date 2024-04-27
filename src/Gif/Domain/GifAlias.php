<?php

declare(strict_types = 1);

namespace Src\Gif\Domain;

final class GifAlias
{
    private string $alias;

    public function __construct(string $alias)
    {
        $this->alias = $alias;
    }

    public function getValue()
    {
        return $this->alias;
    }

}
