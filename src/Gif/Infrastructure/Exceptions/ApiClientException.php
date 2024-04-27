<?php

declare(strict_types = 1);

namespace Src\Gif\Infrastructure\Exceptions;

use Exception;

class ApiClientException extends Exception
{
    protected $message = 'Service Unavailable';
    protected $status = 503;

    public function getStatus()
    {
        return $this->status;
    }
}