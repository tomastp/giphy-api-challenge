<?php

declare(strict_types = 1);

namespace Src\Gif\Domain;

final class GifQueryParams
{
    private string $query;
    private int $offset;
    private int $limit;

    public function __construct( string | array | null $query, string | array | null $offset,  string | array | null $limit)
    {
        $this->validate($query, $offset, $limit);
    }

    public function getValue()
    {
        return $this->query;
    }

    public function getQueryString()
    {
        return "q={$this->query}&limit={$this->limit}&offset={$this->offset}";
    }

    private function validate(string | array | null $query,  string | array | null $offset,  string | array | null $limit)
    {
        $this->query = (preg_match('/^[A-Za-z0-9_-]*$/', $query)) ? $query : '';
        $this->offset = ($offset && preg_match('/^[0-9_-]*$/', $offset)) ?  (int) $offset : 0;
        $this->limit = ($limit && preg_match('/^[0-9_-]*$/', $limit)) ?  (int) $limit : 0;
        
        return true;
    }
}
