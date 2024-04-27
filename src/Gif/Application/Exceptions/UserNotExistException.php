<?php

declare(strict_types = 1);

namespace Src\Gif\Application\Exceptions;

use Exception;

class UserNotExistException extends Exception
{
    protected $message = 'User does not exist.';
    protected $status = 400;

    public function getStatus()
    {
        return $this->status;
    }
}

