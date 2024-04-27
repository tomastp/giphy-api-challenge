<?php

declare(strict_types=1);

namespace Src\User\Domain;

final class UserEmail
{
    private string $email;

    public function __construct( string $email ) {
        $this->email = $email;
    }

    public function getValue()
    {
        return $this->email;
    }

}
