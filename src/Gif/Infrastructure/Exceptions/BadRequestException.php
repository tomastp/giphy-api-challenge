<?php

declare(strict_types = 1);

namespace Src\Gif\Infrastructure\Exceptions;

use Exception;

class BadRequestException extends Exception
{
    protected $message = 'Bad Request.';
    protected $status = 400;

    public function getStatus()
    {
        return $this->status;
    }
}