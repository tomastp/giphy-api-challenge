<?php

declare(strict_types=1);

namespace Src\User\Domain;

final class UserPassword
{
    private string $password;

    public function __construct( string $password ) {
        $this->password = $password;
    }

    public function getValue()
    {
        return $this->password;
    }

}
