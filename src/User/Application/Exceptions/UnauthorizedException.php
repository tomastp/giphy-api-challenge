<?php

declare(strict_types = 1);

namespace Src\User\Application\Exceptions;

use Exception;

class UnauthorizedException extends Exception
{
    protected $message = 'Unauthorized.';
    protected $status = 401;

    public function getStatus()
    {
        return $this->status;
    }
}
