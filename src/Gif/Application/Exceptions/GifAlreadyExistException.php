<?php

declare(strict_types = 1);

namespace Src\Gif\Application\Exceptions;

use Exception;

class GifAlreadyExistException extends Exception
{
    protected $message = 'Gif already exists.';
    protected $status = 422;

    public function getStatus()
    {
        return $this->status;
    }
}


