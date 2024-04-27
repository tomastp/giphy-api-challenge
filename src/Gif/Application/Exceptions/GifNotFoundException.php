<?php

declare(strict_types = 1);

namespace Src\Gif\Application\Exceptions;

use Exception;

class GifNotFoundException extends Exception
{
    protected $message = 'Gif ID not found.';
    protected $status = 404;

    public function getStatus()
    {
        return $this->status;
    }
}

